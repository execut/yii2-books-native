The package has the following functionality:
* Book model class
* Table name by function declaration ```Book::tableName()```
* CRUD navigation
* CRUD controller
    * CRUD access control
    * List output
        * Action to display the list of records
           * Loading filtering parameters
            * Setting validation rules for the search scenario in the model by declaring ```Book::rules()```
            * Model validation by grid scenario
            * Configuring of ActiveQuery based on filtering parameters
            * Configuring ActiveDataProvider for list of records
            * Render view
         * View to display the list of records
            * Output of the add new record button
            * Configuring of list column settings
            * Displaying the list of records via the [kartik-v/yii2-dynagrid](https://github.com/kartik-v/yii2-dynagrid) widget
     * Create or edit records
         * Action to create or edit records
             * If this is not a new entry, then searching for the active model
             * If new entry, then creation
             * Assign edit scenario
             * Load model data from request
             * Setting the model validation rules for the form script by adding ```Simple::rules()```
             * Model data validation
             * Saving the model
             * Errors output
         * View to display the edit form of  active record
             * Configuring of settings of attributes for the edit form
             * Output of edit form
     * Action to delete records
