<?php

/*
 * Project Name: eulims * 
 * Copyright(C)2018 Department of Science & Technology -IX * 
 * Developer: Eng'r Nolan F. Sunico  * 
 * 04 20, 18 , 1:47:16 PM * 
 * Module: RBAC * 
 */

namespace common\components;
use common\models\auth\AuthItem;
use common\models\auth\AuthItemChild;
use common\models\auth\AuthAssignment;
/**
 * Description of RBAC
 *
 * @author OneLab
 */
class RBAC {
    //put your code here
    public function CreateModulePermissions($ModuleName){
        $AuthItem= AuthItem::find()->where("name='/".$ModuleName."/*'")->one();
        if(!$AuthItem){// Create Only if permission does not exits
            //Create Route
            $AuthItem=new AuthItem();
            $AuthItem->name="/".$ModuleName."/*";
            $AuthItem->type=2;
            $AuthItem->save();
            //create permissions
            $AuthItem2=new AuthItem();
            $AuthItem2->name="access-$ModuleName";
            $AuthItem2->description="This permission allow user to access $ModuleName module";
            $AuthItem2->type=2;
            $AuthItem2->save();
            $AuthItemChild=new AuthItemChild();
            $AuthItemChild->parent="access-$ModuleName";
            $AuthItemChild->child="/".$ModuleName."/*";
            $AuthItemChild->save();
        }
    }
    public function CreateSubModulePermissions($ModuleName,$SubModuleName, $Url){
        $AuthItem= AuthItem::find()->where("name='$Url'")->one();
        if(!$AuthItem){// Create Only if permission does not exits
            //Create Route
            $AuthItem=new AuthItem();
            $AuthItem->name=$Url;
            $AuthItem->type=2;
            $AuthItem->save();
            //create permissions
            $AuthItem2=new AuthItem();
            $AuthItem2->name="access-$SubModuleName";
            $AuthItem2->description="This permission allow user to access $SubModuleName Submodule";
            $AuthItem2->type=2;
            $AuthItem2->save();
            $AuthItemChild=new AuthItemChild();
            $AuthItemChild->parent="access-$SubModuleName";
            $AuthItemChild->child=$Url;
            $AuthItemChild->save();
        }
    }
    
}
