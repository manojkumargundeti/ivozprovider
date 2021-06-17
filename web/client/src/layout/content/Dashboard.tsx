import { withRouter } from "react-router-dom";
import entities from '../../entities/index';
import { Link } from "react-router-dom";
import { Grid } from "@material-ui/core";

interface dashboardProps {
}

const Dashboard = (props:dashboardProps) => {

  return (
    <Grid container spacing={3}>
        <Grid item xs={6}>
            <ul>
                <li>
                    <Link to={entities.User.path}>
                        {entities.User.title}
                    </Link>
                </li>
                <li>
                    <Link to={entities.Terminal.path}>
                        {entities.Terminal.title}
                    </Link>
                </li>
                <li>
                    <Link to={entities.Extension.path}>
                        {entities.Extension.title}
                    </Link>
                </li>
                <li>
                    <Link to={entities.Ddi.path}>
                        {entities.Ddi.title}
                    </Link>
                </li>
                <li className="submenu">
                    <h3>Routing endpoints</h3>
                    <div>
                        <ul>
                            <li>
                                <Link to={entities.Ivr.path}>
                                    {entities.Ivr.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.HuntGroup.path}>
                                    {entities.HuntGroup.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.Queue.path}>
                                    {entities.Queue.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.ConditionalRoute.path}>
                                    {entities.ConditionalRoute.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.Friend.path}>
                                    {entities.Friend.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.ConferenceRoom.path}>
                                    {entities.ConferenceRoom.title}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </li>
                <li className="submenu">
                    <h3>Routing tools</h3>
                    <div>
                        <ul>
                            <li>
                                <Link to={entities.ExternalCallFilter.path}>
                                    {entities.ExternalCallFilter.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.Calendar.path}>
                                    {entities.Calendar.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.Schedule.path}>
                                    {entities.Schedule.title}
                                </Link>
                            </li>
                            <li>
                                <Link to={entities.MatchList.path}>
                                    {entities.MatchList.title}
                                </Link>
                            </li>
                            <li>
                                Route Locks
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </Grid>
        <Grid item xs={6}>
            <ul>
                <li className="submenu">
                    <h3>User configuration</h3>
                    <div>
                        <ul>
                            <li>
                                Outgoing DDI Rules
                            </li>
                            <li>
                                Pick up groups
                            </li>
                            <li>
                                Call ACLs
                            </li>
                        </ul>
                    </div>
                </li>
                <li className="submenu">
                    <h3>Multimedia</h3>
                    <div>
                        <ul>
                            <li>
                                Locutions
                            </li>
                            <li>
                                Music on Hold
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    Faxes
                </li>
                <li>
                    Services
                </li>
                <li>
                    Rating Profiles
                </li>
                <li>
                    Invoices
                </li>
                <li className="submenu">
                    <h3>Calls</h3>
                    <div>
                        <ul>
                            <li>
                                Active calls
                            </li>
                            <li>
                                Call registry
                            </li>
                            <li>
                                External calls
                            </li>
                            <li>
                                Call CSV schedulers
                            </li>
                            <li>
                                Call recordings
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </Grid>
    </Grid>

  );
};

export default withRouter<any, any>(Dashboard);