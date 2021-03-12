import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Item } from './item';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  //Declarations & variables
  PHP_API_SERVER = "http://localhost/StoklyAssignment/backend";
  items: Item[];

  constructor(private httpClient: HttpClient) { }

  /**
   * readItems()
   * @returns 
   * Description: The data returned from the server via get() is the list of items
   *  wrapped inside an external array e.g.data (a common case when consuming APIs).
   * Since we are interested only in the list of items in the innermost array we
   *  need to extract the list. For this job, we will use the RxJS pipe() operator that
   *  we need to chain to the get() method. Inside the pipe operator, 
   * you will map the array of items that come from the server side to the service's local items variable.
   */
  readItems(): Observable<Item[]> {
    return this.httpClient.get(`${this.PHP_API_SERVER}/api/read.php`).pipe(
      map((res) => {
        this.items = res['data'];
        return this.items;
      }),
      catchError(this.handleError));
  }//readItems

  /**
   * addItem
   * @param item 
   * @returns 
   * Description: httpClientModule's post() method is to send the data to the server side.
   *  The method accepts the URL as the first parameter and the item object as the second parameter.
   * The data retrieved from the server side includes the data about the newly created item (id and item
   *  name), which we will push to the list of items in the service. 
   * The method then returns the updated list of items to the component.The handleError method
   *  handles any error that might occur.
   */
  addItem(item: Item): Observable<Item[]> {
    return this.httpClient.post(`${this.PHP_API_SERVER}/api/create.php`, { data: item })
      .pipe(map((res) => {
        this.items.push(res['data']);
        return this.items;
      }),
        catchError(this.handleError));
  }//addItem

  /**
   * updateItem
   * @param item 
   * @returns 
   * Description: In the case of success, the update() method needs to return the updated list of items.
   * For this, the find method on the list of items to search for the items that needs to be updated,
   *  before updating it with the data entered by the user.
   */
  updateItem(item: Item): Observable<Item[]> {
    return this.httpClient.put(`${this.PHP_API_SERVER}/api/update.php`, { data: item })
      .pipe(map((res) => {
        const theItem = this.items.find((findthis) => {
          return +findthis['ID'] === +item['ID'];
        });
        console.log(theItem);
        if (theItem) {
          theItem['item'] = item['item'];

        }
        console.log(this.items);
        return this.items;
      }),
        catchError(this.handleError));
  }//updateItem

  /**
   * deleteItem
   * @param ID 
   * @returns 
   * Description: In the case of success, the delete() method needs to return the updated list of items,
   *  without the deleted item. 
   */
  deleteItem(ID: number) {
    return this.httpClient.delete<Item>(`${this.PHP_API_SERVER}/api/delete.php/?ID=${ID}`);
  }//deleteItem

  /**
   * handleError
   * @param error 
   * @returns 
   * Description: Throws an error
   */
  private handleError(error: HttpErrorResponse) {
    console.log(error);

    // return an observable with a user friendly message
    return throwError('Error! something went wrong.');
  }//handleError

}//class ApiService
