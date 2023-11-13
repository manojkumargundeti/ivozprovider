package config

import (
	"fmt"

	"github.com/spf13/viper"
)

func InitConfig() error {
	viper.SetConfigName("config")
	viper.SetConfigType("yaml")
	viper.AddConfigPath("/opt/irontec/ivozprovider/microservices/realtimego/configs")

	return viper.ReadInConfig()
}

func GetWsListenAddress() string {
	return viper.GetString("ws.listen")
}

func GetJWTCertificate() string {
	return viper.GetString("ws.jwt_public")
}

func GetJWTPrivateKey() string {
	return viper.GetString("ws.jwt_private")
}

func GetHttpApiBrand() string {
	return viper.GetString("http.api.brand")
}

func GetHttpApiClient() string {
	return viper.GetString("http.api.client")
}

func GetHttpApiPlatform() string {
	return viper.GetString("http.api.platform")
}

func GetRedisSentinelAddr() string {
	return fmt.Sprintf(
		"%s:%s",
		viper.GetString("redis.sentinel_host"),
		viper.GetString("redis.sentinel_port"),
	)
}

func GetRedisPool() int {
	return viper.GetInt("redis.pool_size")
}

func GetRedisMaster() string {
	return viper.GetString("redis.master")
}
