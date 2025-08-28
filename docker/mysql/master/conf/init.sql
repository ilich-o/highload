CREATE USER replica@'%' IDENTIFIED WITH mysql_native_password BY 'replica';
GRANT REPLICATION SLAVE ON *.* TO replica@'%';
