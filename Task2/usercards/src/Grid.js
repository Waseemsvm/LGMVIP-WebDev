import React, { Component } from 'react'
import './App.scss'

class Grid extends Component{
    constructor(props){
        super(props)

        this.state = {
            users: this.props.users,
            isFetching: true,
            clicked: this.props.clicked
        }
    }


    render(){

        console.log(this.props.clicked)

        if(!this.props.clicked){
            return(
                <div className="Grid">
                    <div className="loading">
                    <h1>
                         Click Get Users Button to display the details
                    </h1>
                    </div>
                </div>
                
            )
        }else{
            const {isFetching} = this.props;
            // const isFetching = true
           return (

                <div className="Grid">
                     { isFetching ? 
                        (
                            <div className="loading">
                                <div className="loadingio-spinner-magnify-6xpsy2q86zk loading">
                                    <div className="ldio-9l89rm1sjrm">
                                        <div>
                                            <div>
                                                 <div>
                                                 </div>
                                            <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            
                            
                        ): (
                            <div>
                                <ul className="cards">
                                    {
                                        this.props.users.map( ({id, email, avatar, first_name, last_name})=> (
                                            <li key={id} className="card">
                                                <img src={avatar} alt="avatar"/>
                                                <h1>
                                                    {first_name + " " + last_name}
                                                </h1>
                                                <p>{email}</p>
                                            </li>
                                        ))
                                    }
                                </ul>
                            </div>
                        )}
                </div>
              
           )
        }

           
        
    }
}

export default Grid