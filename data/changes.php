 

/* 
 * change the last_login type as the integer is 11 but date is 15 , we have datetime for other dates, need null value to convert
 */
 
UPDATE `user` SET `last_login` = NULL WHERE  1;
ALTER TABLE `user` CHANGE `last_login` `last_login` DATETIME NULL; 

---------------------------
