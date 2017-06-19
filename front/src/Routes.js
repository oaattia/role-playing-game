import React from 'react'
import {
    BrowserRouter as Router,
    Route,
    Link
} from 'react-router-dom'
import LoginForm from './LoginForm';
import RegisterForm from './RegisterForm';

const Login  = () => (
    <div className="container">
        <Login/>
    </div>
)


const Routes = () => (
    <Router>
        <div className="row">
                {/*<li><Link to="/">Home</Link></li>*/}
                {/*<li><Link to="/about">About</Link></li>*/}
                {/*<li><Link to="/topics">Topics</Link></li>*/}
                {/*<li><Link to="/login">Login</Link></li>*/}
                <div className="buttons">
                    <Link to="/login" className="btn btn-default">Login</Link>
                    <Link to="/register" className="btn btn-default">Register</Link>
                    {/*<a href="#" className="btn btn-lg btn-default button-wrapper">Login</a>*/}
                    {/*<a href="#" className="btn btn-lg btn-primary button-wrapper">Register</a>*/}
                </div>
            <hr/>

            {/*<Route exact path="/" component={Home}/>*/}
            {/*<Route path="/about" component={About}/>*/}
            {/*<Route path="/topics" component={Topics}/>*/}

            <Route path="/login" component={LoginForm}/>
            <Route path="/register" component={RegisterForm}/>

        </div>
    </Router>
)

export default Routes