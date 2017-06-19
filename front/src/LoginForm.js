import React, {Component} from 'react';

export default class LoginForm extends Component {

    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: ''
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(event) {
        console.log(event.target.value);
        this.setState({ [event.target.name] : event.target.value });
    }


    handleSubmit(event) {
        event.preventDefault();
        console.log(this.state);
    }


    render() {
        return (
            <div className="LoginForm">
                <form className="form-horizontal">
                    <fieldset>
                        <div className="form-group">
                            <label className="col-lg-2 control-label">Email</label>
                            <div className="col-lg-8">
                                <input type="text" className="form-control" name="email" id="inputEmail" onChange={this.handleChange} value={this.state.email} />
                            </div>
                        </div>
                        <div className="form-group">
                            <label className="col-lg-2 control-label">Password</label>
                            <div className="col-lg-8">
                                <input type="password" className="form-control" name="password" id="inputPassword" onChange={this.handleChange}  value={this.state.password} />
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

