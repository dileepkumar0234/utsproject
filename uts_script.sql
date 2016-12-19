
ALTER TABLE `umpiretaxpayer`.`user_details` CHANGE `visa_type` `visa_type` VARCHAR(100) CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `umpiretaxpayer`.`user_details` CHANGE `c_location` `c_location` VARCHAR(100) CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `umpiretaxpayer`.`user_details` ADD COLUMN `insurence` VARCHAR(100) NULL AFTER `visa_type`; 
ALTER TABLE `umpiretaxpayer`.`user_details` ADD COLUMN `itin` VARCHAR(100) NULL AFTER `ssnitin`; 

ALTER TABLE `processing_status` ADD COLUMN `ps_year` INT(10) NULL AFTER `ps_state`; 
UPDATE `processing_status` SET `ps_year`=2015 WHERE `ps_added_at`!=""
ALTER TABLE `processing_status` CHANGE `ps_state` `ps_state` INT(10) NULL COMMENT '0-Assigned,1-Basic,2-Schduling,3-Interview,4-Doc pending,5-Other Doc,6-Preparation,7-Synopses,8-Payment,9-Review Upload,10-Review pending,11-E fileing pending,12-P filing pending,13-E filing complete,14-P filing doc sent,15-File cancelled'; 
CREATE TABLE `upload_types`( `upt_id` INT(11) NOT NULL AUTO_INCREMENT, `upt_name` VARCHAR(100), `upt_status` TINYINT DEFAULT 1, `upt_created_at` DATETIME, `upt_updated_at` DATETIME, PRIMARY KEY (`upt_id`) ); 

ALTER TABLE `dependent` ADD COLUMN `ssn` VARCHAR(50) NULL AFTER `phone`, ADD COLUMN `itin` VARCHAR(50) NULL AFTER `ssn`, ADD COLUMN `visa_type` VARCHAR(100) NULL AFTER `itin`; 
ALTER TABLE `employee_info` ADD COLUMN `client_name` VARCHAR(100) NULL AFTER `company_name`, ADD COLUMN `proj_start_date` DATE NULL AFTER `client_name`, ADD COLUMN `proj_end_date` DATE NULL AFTER `proj_start_date`; 