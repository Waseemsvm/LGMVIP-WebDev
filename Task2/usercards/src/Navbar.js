
import React, { Component } from 'react'
import './App.scss'

class Navbar extends Component {
    constructor(props){
        super(props)

        this.state = {
            users: null,
            isFetching: null,
            clicked: false
        }

        this.handleClick = this.handleClick.bind(this)
    }

   async handleClick(){
       
           this.setState({clicked: true}, () => {
            this.props.checkClicked(this.state.clicked)
            this.props.requestData(this.state.users, true)
        })
        
        const data = await fetch('https://reqres.in/api/users')

        const users = await data.json()

        this.setState({users: users.data}, () => {
            this.props.requestData(this.state.users, false)
        })

        
    }

    render(){
        return(
            <div className="Navbar">
                <div className="logo">

                </div>
                <div className="loadButton">
                    <button className="button" onClick={ this.handleClick}>Get Users</button>
                </div>
                
            </div>
        )
    }
}

export default Navbar