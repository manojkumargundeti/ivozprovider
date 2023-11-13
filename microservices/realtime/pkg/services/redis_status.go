package services

import (
	"context"
	"encoding/json"
	"fmt"
	"strconv"
	"time"

	"github.com/redis/go-redis/v9"
	"irontec.com/realtime/pkg/config"
)

type EventData struct {
	Event     string `json:"Event"`
	Time      int64  `json:"Time"`
	ID        string `json:"ID"`
	CallID    string `json:"Call-ID"`
	Party     int    `json:"Party"`
	Brand     string `json:"Brand"`
	Company   string `json:"Company"`
	Direction string `json:"Direction"`
	Owner     string `json:"Owner"`
}

const REDIS_KEYS_IN_CALL_TTL = 60*60*3 + 30
const REDIS_KEYS_TTL = 60 * 2

// Constants
const (
	CALL_SETUP  = "Trying"
	RINGING     = "Early"
	IN_CALL     = "Confirmed"
	HANG_UP     = "Terminated"
	UPDATE_CLID = "UpdateCLID"
)

var SIGNIFICANT_CALL_EVENTS = [...]string{CALL_SETUP, RINGING, IN_CALL, HANG_UP, UPDATE_CLID}

func InitRedisControlClients() {
	redisClient := redis.NewFailoverClient(&redis.FailoverOptions{
		MasterName: config.GetRedisMaster(),
		SentinelAddrs: []string{
			config.GetRedisSentinelAddr(),
		},
		DB: 1,
	})

	channelPatterns := []string{"trunks:*", "users:*"}
	pubsub := redisClient.PSubscribe(context.Background(), channelPatterns...)
	defer pubsub.Close()

	ch := pubsub.Channel()
	for {
		select {
		case msg := <-ch:
			updateCurrentCallsStatus(msg, redisClient)
		}
	}
}

func updateCurrentCallsStatus(msg *redis.Message, redisClient *redis.Client) {
	payload := msg.Payload
	channel := msg.Channel

	var eventData EventData
	err := json.Unmarshal([]byte(payload), &eventData)
	if err != nil {
		fmt.Println("Error:", err)
		return
	}

	event := eventData.Event
	if event == HANG_UP {
		fmt.Println("[DEL] " + channel)
		redisClient.Del(context.Background(), channel)
		return
	}

	if event == CALL_SETUP {
		fmt.Println("[SETEX] " + channel + "\n" + payload)
		redisClient.SetEx(
			context.Background(),
			channel,
			payload,
			REDIS_KEYS_TTL,
		)
		return
	}

	dataStr, err := redisClient.Get(context.Background(), channel).Result()
	// Convert the result to a string
	if err != nil {
		fmt.Println("Error converting result to string:", err)
		return
	}

	var data EventData
	err = json.Unmarshal([]byte(dataStr), &data)
	if err != nil {
		fmt.Println("Error:", err)
		return
	}

	var logInfo string
	if event == UPDATE_CLID {
		data.Party = eventData.Party
		logInfo = event + " => party " + strconv.Itoa(data.Party)
	} else {
		data.Event = event
		logInfo = event
	}

	fmt.Println("[SETEX] ", channel+" "+logInfo)

	ttl := func() int {
		if event == "IN_CALL" {
			return REDIS_KEYS_IN_CALL_TTL
		}
		return REDIS_KEYS_TTL
	}()

	redisClient.SetEx(
		context.Background(),
		channel, dataStr,
		time.Duration(ttl),
	)

}
