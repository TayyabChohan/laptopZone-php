


var MainApp = React.createClass({

	getInitialStage(){

		return {
			currentMode : 'create',
            productId: null
		};

	}

	changeAppMode(newMode,productId){

		this.setState({currentMode : newMode});
		if(productId !== undefined ){
			this.setState({productId :productId});
		}

	}

	render(){
		var modeComponent = <MyComponent changeAppMod={this.changeAppMode}/>;
		switch(this.state.currentMode){
			case 'create':

		}

	}




});


// var el = document.getElementById('content');

// function LoginButton(props){
// 	return <button  onClick ={props.onClick}>login</button>
// }function LogoutButton(props){
// 	return <button  onClick ={props.onClick}>logout</button>
// }
// class LoginFunc extends React.Component{

// 	constructor(props){
// 		super(props)

// 		this.loginEvent = this.loginEvent.bind(this);
// 		this.logoutEvent = this.logoutEvent.bind(this);
// 		this.state = {isLoggedIn : false};

// 	}
// 	loginEvent(e){
// 		this.setState({isLoggedIn:true});

// 	}
// 	logoutEvent(e){
// 		this.setState({isLoggedIn:false});
// 	}
// 	render(){
// 		const button = this.state.isLoggedIn ? 
// 		(<LogoutButton onClick= {this.logoutEvent}/>) : 
// 		(<LoginButton onClick= {this.loginEvent}/>);
// 		const mesage = this.state.isLoggedIn ? (<h1>welcom back</h1>) :(<h1>not login</h1>);
// 			return <div>
// 			{mesage}
// 			{button}
// 			</div>
// 	}
// }


// ReactDOM.render(<LoginFunc/>,el);