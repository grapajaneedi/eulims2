/* 
 * Quarks Digital Solutions
 * Website Developed by: Nolan F. Sunico
 * Date Created: 14 Jul, 2018
 * Time Created: 10:43:39 AM
 * Module: TableObject
 * Project: EULIMS.
 * sample on how to access html table using this class
    var table=new tableobject("tblOR"); 
    var tot=table.contentrowcount;//get the total rows in tbody
    var fields=[tot+1,"2018010130881",1,1,1,2,""];// array contains the data 
    // array that contained the class of each td
    var fieldarr=["kv-align-center","kv-align-left","kv-align-center","kv-align-center","kv-align-center","kv-align-center",""];
    table.insertrow(fields,fieldarr);
 */
function selectRow(ctrl,id){
    $(ctrl).addClass('info').siblings().removeClass('info');
    tableobject.currentRowIndex=$(ctrl).attr("data-key");
    //this.currentRowIndex=
    
}
/**
 * 
 * @param {string} table_id
 * @returns {table DOM object}
 */
class tableobject{
    constructor(table_id){
        this.id=table_id;
        this.table = document.getElementById(table_id).getElementsByTagName('tbody')[0];
        this.contentrowcount=parseInt($("#"+this.id+">tbody>tr").length);
        this.currentRowIndex=0;
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
     * @param {array} fields
     * @param {array} fieldsclass
     * @returns {tableobject.insertfooter.row|tableobject.insertfooter@pro;table@call;insertRow}
     */
    insertfooter(fields=[],fieldsclass=[]){
       var mtable=document.getElementById(this.id);
       var footer=mtable.createTFoot();
       var row=footer.insertRow(0);
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
    * @param {array} fields cell value
    * @param {array} fieldsclass class for td cell
    * @param {integer} index
    * @returns {TableObject.insertrow.row}
    */
    insertrow(fields=[],fieldsclass=[],index=-1){
        if(index==-1){
            index=this.table.rows.length;
        }
        var row=this.table.insertRow(index);
        row.setAttribute("class", "clickable-row");
        row.setAttribute("data-key",index);
        row.setAttribute("onClick", "selectRow(this,"+this.id+")");
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
     * @description Removes all rows from the table
     * @returns {none}
     */
    truncaterow(){
        $("#"+this.id+" tbody>tr").remove(); 
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
