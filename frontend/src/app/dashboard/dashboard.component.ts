import { Component, OnInit } from '@angular/core';
import { Item } from '../item';
import { ApiService } from '../api.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})

export class DashboardComponent implements OnInit {

  //Declarations & Variables
  items = [];
  error = '';
  success = '';
  selectedItem: Item = { ID: null, item: null };

  constructor(private apiService: ApiService) { }

  ngOnInit() {
    this.getItems();
  }//ngOnInit()

  /**
   * getItems()
   * Description: method that subscribers to the data that comes from the service
   */
  getItems(): void {
    this.apiService.readItems().subscribe(
      (ret: any[]) => {
        this.items.push(ret);        
      }
    ),
      (err) => {
        this.error = err;
      }
  }//getItems()



  /**
   * addItem
   * @param f 
   * Description: Method that receives the values entered into the form before sending 
   * them to the service.
   */
  addItem(f) {
    //Call to function resetErrors() to reset error and success variable
    this.resetErrors();

    this.apiService.addItem(f.value)
      .subscribe(
        (res: Item[]) => {
          // Update the list of cars
          this.items.push(res);

          // Inform the user
          this.success = 'Created successfully';

          console.log(this.items);
           //Refresh page to view changes
           location.reload();  

          // Reset the form
          f.reset();
        },
        (err) => this.error = err
      );
  }//addItem(f)

  /**
   * updateItem
   * @param ID 
   * @param name 
   * Description: The method gets the values from the form and subscribes to the update() method in the service.
   */
  updateItem(ID, name) {
    //Call to function resetErrors() to reset error and success variable
    this.resetErrors();
    this.apiService.updateItem({ ID: +ID, item: name.value })
      .subscribe(
        (res) => {
          this.items.push(res);
          this.success = 'Updated successfully';

          //Refresh page to view changes after 3secs
          setTimeout(function(){ location.reload(); }, 3000);  
        },
        (err) => this.error = err
      );
  }//updateItem


  /**
   * deleteItem
   * @param ID 
   * Description: The method gets the id from the form and subscribes to the delete() method in the service. 
   */
  deleteItem(ID) {
    //Call to function resetErrors() to reset error and success variable
    this.resetErrors();

    this.apiService.deleteItem(ID).subscribe((item: Item) => {
      this.success = 'Deleted successfully';
      
       //Refresh page to view changes after 3secs
       setTimeout(function(){ location.reload(); }, 3000);  
    },
      (err) => this.error = err
    );
  }//deleteItem

  /**
   * resetErrors
   * Description: Resets success & error variables to null
   */
  private resetErrors() {
    this.success = '';
    this.error = '';
  }//resetErrors()
}//class DashboardComponent