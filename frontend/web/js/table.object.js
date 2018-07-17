/* 
 * Quarks Digital Solutions
 * Website Developed by: Nolan F. Sunico
 * Date Created: 14 Jul, 2018
 * Time Created: 10:43:39 AM
 * Module: TableObject
 * Project: Port_Management_System.
 */
/**
 * 
 * @param {string} table_id
 * @returns {table DOM object}
 */
class tableobject{
    constructor(table_id){
        this.id=table_id;
        this.table = document.getElementById(table_id);
        this.contentrowcount=parseInt($("#"+this.id+">tbody>tr").length);
        return this;
    }
    /**
     * @description return row as an array
     * @param {integer} index
     * @returns {TableObject.table.rows}
     */
    row(index){
       return this.table.rows[index]; 
    }
    /**
     * @description return rows as an aray
     * @returns {TableObject.table.rows}
     */
    rows(){
       return this.table.rows;  
    }
   /**
    * 
    * @param {array} fields cell value
    * @param {array} fieldsclass class for td cell
    * @param {integer} index
    * @returns {TableObject.insertrow.row}
    */
    insertrow(fields=[],fieldsclass=[],index=-1){
        var row=this.table.insertRow(index);
        for (var i = 0; i < fields.length; i++) { 
            var cell = row.insertCell(i);
            if(fieldsclass[i]){//check if there is class for td
                cell.setAttribute("class", fieldsclass[i]);
            }
            cell.innerHTML=fields[i];
        }
        return row;
    }
    /**
     * 
     * @param {integer} index
     * @returns {none}
     */
    deleterow(index){
        this.table.deleteRow(index);
    }
    /**
     * @description Converts the html table to json format
     * @returns {JSON Format}
     */
    rowsToJSON(){
        var table = $('#'+this.id).tableToJSON(); 
        return JSON.stringify(table);
    }
    /**
     * @description return the total rows on tbody
     * @returns {_$.length|$.length}
     */
    totalcontentrows(){
       return this.contentrowcount; 
    }  
};
