import React, {Component} from 'react';
import './App.css';
import './bootstrap.css';
import _ from 'lodash';
import swal from 'sweetalert';
import 'parsleyjs';
import Routes from './Routes';

class App extends Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="container">
                <Routes />
            </div>
        );
    }
}

export default App;
