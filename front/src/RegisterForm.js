import React, {Component} from 'react';
import swal from 'sweetalert';
import axios from 'axios';

export default class RegisterForm extends Component {

    constructor(props) {
        super(props);

        this.state = {
            email: '',
            password: '',
            confirmPassword: ''
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        this.setState({[event.target.name]: event.target.value})
    }

    handleSubmit(event) {
        event.preventDefault();
        console.log(this.state);
        if (this.state.password != this.state.confirmPassword) {
            swal('Oops...', 'Please make sure passwords are similar!', 'error');
        }

        axios.post('http://api.app/api/user/register', {
            'email' : this.state.email,
            'password' : this.state.password
        }).then((response) => {
            console.log(response);
        });
    }

    render() {

        return (
            <div className="RegisterForm">
                <form className="form-horizontal">
                    <fieldset>
                        <div className="form-group">
                            <label className="col-lg-2 control-label">Email</label>
                            <div className="col-lg-8">
                                <input type="text" name="email" className="form-control" id="inputEmail"
                                       placeholder="Email" onChange={this.handleChange}/>
                            </div>
                        </div>
                        <div className="form-group">
                            <label className="col-lg-2 control-label">Password</label>
                            <div className="col-lg-8">
                                <input type="password" name="password" className="form-control" id="inputPassword"
                                       placeholder="Password" onChange={this.handleChange}/>
                            </div>
                        </div>
                        <div className="form-group">
                            <label className="col-lg-2 control-label">Repeat Password</label>
                            <div className="col-lg-8">
                                <input type="password" name="confirmPassword" className="form-control"
                                       id="inputPassword" placeholder="Repeat Password" onChange={this.handleChange}/>
                            </div>
                        </div>
                        <div className="form-group">
                            <div className="col-lg-11 col-lg-offset-4">
                                <button className="btn btn-primary" onClick={this.handleSubmit}>Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        );
    }
}

