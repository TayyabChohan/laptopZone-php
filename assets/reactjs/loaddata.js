class MyComponent extends React.Component {
  constructor(props) {
  	//console.log('1');
    super(props);
    this.state = {
      error: null,
      isLoaded: false,
      items: []
    };
  }

  // loadData(){
 	// 	fetch("http://localhost/laptopzone/aasingleentry/c_react_single/load_dumy_data")
  //     .then(res => res.json())
  //     .then(
  //       (result) => {
  //         this.setState({
  //           isLoaded: true,
  //           items: result.items
  //         });
  //       },
  //       // Note: it's important to handle errors here
  //       // instead of a catch() block so that we don't swallow
  //       // exceptions from actual bugs in components.
  //       (error) => {
  //         this.setState({
  //           isLoaded: true,
  //           error
  //         });
  //       }
  //     )
 	// }
 	// componentWillMount(){
 	// 	this.loadData();

 	// }	
 	componentDidMount(){
 		//console.log('2');
 		
 	fetch("http://localhost/laptopzone/aasingleentry/c_react_single/load_dumy_data")
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({
            isLoaded: true,
            items: result.items
          });
        },
        // Note: it's important to handle errors here
        // instead of a catch() block so that we don't swallow
        // exceptions from actual bugs in components.
        (error) => {
          this.setState({
            isLoaded: true,
            error
          });
        }
      )
 	}
 	componentDidUpdate(){
 		//console.log('3');
 		$('#example').dataTable({
		  "bAutoWidth": false,
		  "bDestroy": true,	
		});
 	}

  render() {
  	//console.log('4');
    const { error, isLoaded, items } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
      	<div>
      		<table className="table table-bordered table-hover " id="example"  >
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Barcode</th>
                            <th>Old Barcode</th>
                            <th>Ref No</th>
                            <th>Purchase Date</th>
                            <th>Manufacture</th>
                            <th>Ebay Id</th>
                        </tr>
                    </thead>
                    <tbody>                   
                    {items.map(item => (
                                <tr key={item.ID}>
                                    <td>{item.ACTIONS}</td>
                                    <td>{item.OLD_BARCODE}</td>
                                    <td>{item.OLD_BARCODE}</td>
                                    <td>{item.PURCHASE_REF_NO}</td>
                                    <td>{item.PURCHASE_DATE}</td>

                                    <td>{item.ITEM_MT_MANUFACTURE}</td>
                                    <td>{item.EBAY_ITEM_ID}</td>
                                </tr>
			          ))}                        
                    </tbody>
              </table>
      	</div>
       
      );
    }
  }
}
ReactDOM.render(< MyComponent / >, document.getElementById('content'));