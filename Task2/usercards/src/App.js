
import React from 'react';
import { Component } from 'react';
import './App.scss';
import Navbar from './Navbar'
import Grid from './Grid'

class App extends Component{
  constructor(props){
    super(props)

    this.state = {
      users: null, 
      isFetching: null,
      clicked: false
    }

    this.requestData = this.requestData.bind(this)
    this.checkClicked = this.checkClicked.bind(this)
  }

  requestData = (users, isFetching) => {
    this.setState({users: users, isFetching: isFetching})
  }

  checkClicked = (clicked) => {
    this.setState({clicked : clicked})
  }


  render(){

    return(
      <div className="App">
        <Navbar requestData = {this.requestData} checkClicked={this.checkClicked}/>
        <Grid users={this.state.users} isFetching= {this.state.isFetching} clicked={this.state.clicked}/>
      </div>
    )
  }

}

export default App;
