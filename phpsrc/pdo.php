<?php
	/********************* COPYRIGHT NOTICE ********************
	*  This code is copyrighted by Richard Koontz and may not
	*      be copied or distributed without his written permission
	**********************************************************************/

        /******************************************************
        * FUNCTIONS
        * getPDO() - creates a connection
        * getRecord(tableName, pkName, pkValue) - retrieves a record
        * getRecordSet(query, array) - retrieves multiple records
        * runQuery(query) - runs a query with no passed parameters
        * displayRecordSet($result) - displays recordset results
        * getTableStructure(tablename) - gets a table definition
        * println($text) - echos out a line of text with <br>
        * insertRecord(tableName, recordArray, autoincrement value) - inserts record into db
        * updateRecord(tableName, recordArray, pkfield, pkvalue) - updates a record based on pk
        * delRecord(tableName, pkName, pkValue) - deletes record based on pk
        * delRecords(tablename,fieldname,value) - deletes records based on field values
        * quickButton($target, $caption ) - create a link button (test mode)

		/***** getPDO() ***************************************
		* This function opens a pdo connection object
		*   to use, modify the database, library and user
		*   in the lines below.
		* This function returns a PDO statement connected to the
		*    database.
		*
		*   sample use:   $stmt = getPDO();
		*******************************************************/
		function getPDO(){
			$host = "localhost";
			$db = "f18lithgow";
			$user = "lithgow";
			$pass = "1509904";

			$charset = 'utf8';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

			$opt = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   =>false,
			];

			try{
				$pdo = new PDO($dsn, $user, $pass, $opt);
			}
			catch(PDOException $e){
				echo "<br>Error opening connection: $e";
				$pdo=0;
			}
			return $pdo;

		}

		/***** getRecord(tableName, pkName, pkValue) ***********
		* This function retrieves one record from the specified
		*   table.  To use, pass in the table name, the name of
		*   the primary key, and the value for the primary key.
		* This function returns a record from the database table in
		*   the form of an associative array.
		*
		* sample use:  $record=getRecord("books","isbn",$isbn);
		*******************************************************/
		function getRecord($table, $pkname, $pk){

			$pk = filter_var($pk,FILTER_SANITIZE_STRING);
			//get the book from the database
			$query = "select * from $table where $pkname=?";
			//echoln( $query."  passed key= ".$pk);
			//create the pdo object
			$pdo = getPDO();
			//create the statement
			try{
				$stmt = $pdo->prepare($query);
			}
			catch(PDOException $e){
				print $e;
				//print_r($stmt->errorInfo());
			}
				//execute the query
				//$stmt->execute([$pk]);
			try{
				$stmt->execute(array($pk));
		   }
			catch(PDOException $e){
				print_r($stmt->errorInfo());
			}
			$row = $stmt->fetch();
			return $row;
		}



		/***** getRecordSet(query, array) ***********
		* This function retrieves a set of records from the specified
		*   table.  To use, pass in the query (with
		*   question marks for bound fields, and an array holding all
		*   of the bound fields: array[1]=field value.
		* This function returns a recordset from the database table in
		*   the form of an associative array.
		*
		* sample use:
		*    $query = "SELECT * FROM books WHERE title LIKE ?";
		*    $param[1] = "%$searchterm%";
		*	 $rs=getRecordSet($query,$params);
		*******************************************************/
		function getRecordSet($query,$parms){
			$i=0;
			foreach($parms as $ps){
				$parms[$i] = filter_var($ps,FILTER_SANITIZE_STRING);
				$i++;
			}
			//echoln("retrieve recordset...");
			//echoln("query = $query");
			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);
			//bind the parameters
			$i=0;
			foreach($parms as $field){
					$stmt->bindParam($i+1,$parms[$i]);
					//echo "<br>bound parm $i = $parms[$i]";
					$i++;
			}

			//execute the query
			try{
				$stmt->execute();
			}
			catch(PDOException $e){
				print_r($stmt->errorInfo());
			}
			$rs = $stmt->fetchAll();
			return $rs;
		}

		/***** runQuery(query) ***********
		* This function retrieves an array of record data
		*   based on USING A PREBUILT QUERY WITH NO PARAMETERS
		*
		* This function returns a recordset from the database table in
		*   the form of an associative array.
		*
		* sample use:
		*    $query = "SELECT * FROM books WHERE title LIKE ?";
		*	 $rs=getRecord($query);
		*******************************************************/
		function runQuery($query){
			$i=0;
			//echoln("query = ".$query);
			//create the pdo object
			$pdo = getPDO();
			//create the statement

			//execute the query
			try{
				$rs = $pdo->query($query, PDO::FETCH_ASSOC);
			}
			catch(PDOException $e){
				echoln("Error running query: ".$e);
				print_r($stmt->errorInfo());
			}
			//$rs = $stmt->fetchAll();
			return $rs;
		}

		/***** runQuery(query) ***********
		* This function retrieves an array of record data
		*   based on USING A PREBUILT QUERY WITH NO PARAMETERS
		*
		* This function returns a recordset from the database table in
		*   the form of an associative array.
		*
		* sample use:
		*    $query = "SELECT * FROM books WHERE title LIKE ?";
		*    $param[1] = "%$searchterm%";  $param[2] = "value";
		*	 $rs=getRecord($query,$param);
		*******************************************************
		function runParameterQuery($query,$parms){
			$i=0;
			foreach($parms as $ps){
				$parms[$i] = filter_var($ps,FILTER_SANITIZE_STRING);
				$i++;
			}

			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);
			//bind the parameters
			$i=0;
			foreach($parms as $field){
					$stmt->bindParam($i+1,$parms[$i]);
					//echo "<br>bound parm $i = $parms[$i]";
					$i++;
			}

			//execute the query
			try{
				$stmt->execute();
			}
			catch(PDOException $e){
				print_r($stmt->errorInfo());
			}
			$rs = $stmt->fetchAll();
			return $rs;
		}
		*/

		/* displayRecordSet($query)***********************************************
		*       displays the result of a select or describe query in table form.
		*******************************************************************************/
		function displayRecordSet( $result )
		{
			//echo "<br>DisplayRecordSet ";
			$i=0;
			if( !(isset($result)))
			{
				echo "<br>Error! - Empty Set.    (displayRecordSet)";
			}
			else
			{
				echo "<table border = 1>";
				//now print table headings:
				$rc = 0;
				foreach($result as $row)
				{
					//print_r($row);
	       			//$row = $result->fetch_assoc();
	       			//print out headings
	       			if( $rc==0)
	       			{
		       			//echo "<tr><th></th><th></th>";
		       			echo "<tr>";
		       			foreach($row as $key => $val)
		       			{
			       			echo "<th>".$key."</th>";
		       			}
		       			echo "</tr>";
		       			$rc = 1;
	       			}
	       			//set rowclass based on $i
	       			if( $i%2)
	       			{
		       			echo "<tr class=evenrows>";
	       			}
		       		else
	       			{
		       			echo "<tr class=oddrows>";
	       			}
					$i++;
	       			//echo "<td><a href='index2b.php?c=".$editProg."&id=".$row["membID"]."'><img src='pencil.png' border=0></a></td>";
	       			//echo "<td><a href='dltMember.php?id=".$row["membID"]."'><img src='trash.png' border=0></td>";
	       			foreach($row as $value)
	       				echo "<td>".$value."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		}

		/* displayRecordSetE($query)***********************************************
		*       displays the result of a select or describe query in table form.
		*       and provides links for editing, deleting and viewing.
		*******************************************************************************/

		function displayRecordSetE( $result, $edit, $del, $view, $pkfield )
		{
			if(strlen($edit)>2)
				$editLink = $edit;
			if(strlen($view)>2)
				$viewLink = $view;
			if(strlen($del)>2)
				$delLink = $del;
			$i=0;
			if( !(isset($result)))
			{
				echo "<br>Error! - Empty Set.    (displayRecordSet)";
			}
			else
			{
				echo "<table border = 1>";
				//echo "<caption>Table Definition</caption>";
				$id = $_SESSION['user'];
				//println("<a href=index.php?p=$add>add record</a>");
				//print_r($result);
				//now print table headings:
				$rc = 0;
				foreach($result as $row)
				{
					//print_r($row);
	       			//$row = $result->fetch_assoc();
	       			//print out headings
	       			if( $rc==0)
	       			{
		       			//echo "<tr><th></th><th></th>";
		       			echo "<tr>";
						if(isset($viewLink))
							echo "<th>View</th>";
						if(isset($editLink))
							echo "<th>Edit</th>";
						if(isset($delLink))
							echo "<th>Delete</th>";
		       			foreach($row as $key => $val)
		       			{
							if($key != "FundId" && $key != "TransactionId")
							{
								echo "<th>".$key."</th>";
							}
		       			}
		       			echo "</tr>";
		       			$rc = 1;
	       			}
	       			//set rowclass based on $i
	       			if( $i%2)
	       			{
		       			echo "<tr class=evenrows>";
	       			}
		       		else
	       			{
		       			echo "<tr class=oddrows>";
	       			}
					$i++;
	       			//echo "<td><a href='index2b.php?c=".$editProg."&id=".$row["membID"]."'><img src='pencil.png' border=0></a></td>";
	       			//echo "<td><a href='dltMember.php?id=".$row["membID"]."'><img src='trash.png' border=0></td>";

					//is there an edit link?
					if( isset($viewLink))
						echo "<td><a href=index.php?p=".$viewLink."&i=".$row[$pkfield].">view</td>";
						echo $row['$pkfield'];
					if( isset($editLink))
						echo "<td><a href=index.php?p=".$editLink."&i=".$row[$pkfield].">edit</td>";
					if( isset($delLink))
						echo "<td><a href=index.php?p=".$delLink."&i=".$row[$pkfield].">del</td>";
					foreach($row as $value)
					{
						if(!is_int($value))
						{
							echo "<td>".$value."</td>";
						}
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}

		/* getTableStructure(tablename )********************************************************
		 *       reads in file structure and returns it as an array of fields
		 *         $fname = field name
		 *         $ftype = field type
		 *		   $length = length of the field
		 *         $fnumeric = whether or not this is a numeric field - yes = true
		 *         $required = true if value is required, false if null values are permitted
		 *         $defaultval = default value for new record
		 *         $pk = true if this is the primary key
		 *         $auto = true if this is auto_increment
		 *         $fk = true if this is the primary key for another table
		 *		   $fkTable = name of parent table
		 *******************************************************************************/
		 function getTableStructure($table)
		 {
			 $query = "Describe $table";
			 $result = runQuery($query);
			 return $result;

		 }


		/* println($text)**************************************************************
		*       print out a line of text with a <br> at the end
		*******************************************************************************/
		function println($txt)
		{
			echo $txt."<br />";
		}

		/* buildListBox($db, $query)***********************************************
		*       creates a string of results for a list box
		*******************************************************************************/
		function buildListBox($db, $qry, $fkname, $dd )
		{

			$result = runQuery($qry);
			$rows = $result->num_rows;
			$listbox = "";
			if( $rows == 0)
			{
				echo "<br>Error! - Empty Set.    (displayRecordSet)";
				return "N/A";
			}
			else
			{
				for($i=0; $i < $rows; $i++)
				{
	       			$row = $result->fetch_assoc();
	       			$row = $result->fetch_assoc();
					$line="<option value=".$row[$fkname];
					if( $row[$fkname] == $dd)
						$line .= " selected >";
					else if( $dd == false && $i == 0)
						$line .= " selected >";
					else
						$line .= " >";
					$c = 0;
					//add selected fields
	       			foreach($row as $key => $value)
	       			{
						//echo "<br>".$row[$fkname]."  ".$fkname."  ".$value."  ".$key;
						if($fkname == $key)
						{
							$c++;
						}
						else
						{
							$line = $line.$value;
							$c++;
							if( $c==1)
								$line = $line.", ";
							else
								$line = $line." ";
						}

       				}

       				$line = $line."</option>";
       				$listbox = $listbox . $line;
				}
			}
			return $listbox;
		}

		/* buildListBox($db, $query)***********************************************
		*       creates a string of results for a list box
		*******************************************************************************/
		function buildComboDef($fd, $fieldName, $qry, $fkname )
		{
			$fieldList = $fd['fieldList'];
			$sa=$fieldList[$fieldName];
			$sa['combo'] = true;
				$sa['cboQuery'] = $qry;
				$sa['cbofk'] = $fkname;
				$sa['cboDisplay'] = $fkname;
				$sa['alt'] = $fkname;
			$fieldList[$fieldName]=$sa;
			$fd['fieldList']=$fieldList;
			return $fd;
		}

		function buildQuickList($qry, $fktext, $fkid){
			//echo "<br> running query: ".$qry;
			$result = runQuery($qry);
			$c=0;
			$listbox = "";
			foreach($result as $row)
				{
					$c++;
					$line="<option value=".$row[$fkid].">".$row[$fktext]."</option>";
       				$listbox = $listbox . $line;
				}
							return $listbox;
		}
		/*
		//$rows = $result->num_rows;

		if( $c == 0)
		{
			echo "<br>Error! - Empty Set.    (displayRecordSet)";
			return "N/A";
		}
		else
		{
			for($i=0; $i < $rows; $i++)
			{
				$row = $result->fetch_assoc();
				$line="<option value=".$row[$fkname];
				if( $row[$fkname] == $dd)
					$line .= " selected >";
				else if( $dd == false && $i == 0)
					$line .= " selected >";
				else
					$line .= " >";
				$c = 0;
				//add selected fields
				foreach($row as $key => $value)
				{
					//echo "<br>".$row[$fkname]."  ".$fkname."  ".$value."  ".$key;
					if($fkname == $key)
					{
						$c++;
					}
					else
					{
						$line = $line.$value;
						$c++;
						if( $c==1)
							$line = $line.", ";
						else
							$line = $line." ";
					}

				}

				$line = $line."</option>";
				$listbox = $listbox . $line;
			}
			return $listbox;
		}

		/***** delRecord(tableName, pkName, pkValue) ***********
		* This function deletes one record from the specified
		*   table.  To use, pass in the table name, the name of
		*   the primary key, and the value for the primary key.
		* This function returns the number of rows affected.
		*   A zero implies that the record was not deleted.
		*
		* sample use:  $result=delRecord("books","isbn",$isbn);
		*******************************************************/
		function delRecord($table,$pkname, $pk){
			//sanitize the pk value
			//println("");
			//println("table, pkname, pk".$table."  ".$pkname."  ".$pk);

			$pk = filter_var($pk,FILTER_SANITIZE_STRING);
			//set up the query string
			$query = "delete from $table where $pkname=?";
			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);
			//execute the query
			$stmt->execute([$pk]);
			$rowcount = $stmt->rowCount();
			return $rowcount;
		}

		function delRecords($table,$fieldname,$val){
			//sanitize the pk value
			$val = filter_var($val,FILTER_SANITIZE_STRING);
			//set up the query string
			$query = "delete from $table where $fieldname =?";
			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);
			//execute the query
			try{
				$stmt->execute([$val]);
			}
			catch(PDOException $e){
				print_r($stmt->errorInfo());
				$rowcount = 0;
				return $rowcount;
			}
			$rowcount = $stmt->rowCount();
			return $rowcount;
		}

		/***** insertRecord(tableName, recordArray, autoincrement value)
		* This function inserts one record into the specified
		*   table.  To use, pass in the table name, an array which holds
		*   the field names and field values. ['fieldname']=value.
		*   the first field in the array must be the primary key.
		*   this function assumes that the primary key is auto_increment
		*   unless you also pass in a false as the third parameter.  If
		*   you are working with an autoIncrement pk, then no third
		*   parameter is necessary.  If the file does have an auto_increment
		*   primary key, you must still pass in the pk field as the first
		*   value in the array - the pkfield value may be null.
		* This function returns the number of rows affected.  A zero
		*   implies that the function did not create the record.
		*
		* sample use:
        * not autoInc pk:
        *   $username = "koontzrd";
        *   $password = "pass123";
        *   $name = "rick koontz";
        *   $authlevel = 10;
        *   $array = array($username, $password, $name, $authlevel);
		*   $result=insertRecord("books",$array,false);
        *
        * autoincrement pk:
        *   $testid="does not matter";
        *   $testname = "testing";
        *   $testnumber = 42;
        *   $array = array($testid,$testname,$testnumber);
		*   $result=insertRecord("testAuto",$array);
		*******************************************************/
		function insertRecord($table,$record,$autoInc=true){
			//echo "autoinc = $autoInc";
			//sanitize the values
			foreach($record as $k => $val){
				$record[$k] = filter_var($val,FILTER_SANITIZE_STRING);
			}

			$query = "insert into $table values ";
			$i=0;
			$qms="(";
			//echo "<br>add record = ".print_r($record);
			foreach ($record as $key => $value){
				//echo "<br>$key -> $value";
				if ($i==0){
					if($autoInc=="Yes"){
						$qms = $qms."null";
					}
					else
						$qms = $qms."?";
				}
				else{
					$qms = $qms.",?";
				}
				$i++;
			}
			$query .= $qms.")";
			//echo "<br>query = $query";

			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);

			//bind the fields
			$i=0;
			foreach($record as $key => $field){
				if($i==0 && $autoInc==true){
					//do nothing here as pk = null.
				}
				else{
					if($i==0)
						$i++;
					$stmt->bindParam($i,$record[$key]);
					//echo "<br>bound: $i -> $record[$key]";
				}
				$i++;

			}
			//execute the query
			try{
				$stmt->execute();
			}
			catch(PDOException $e){
				echo "<br>***ERROR INSERTING RECORD:";
				print_r($stmt->errorInfo());
				echo "<br>DUMP PARAMS:";
				$stmt->debugDumpParams();
				$rowcount = 0;
				return $rowcount;
			}

			$rowcount = $stmt->rowCount();

			//echo "<br>rowcount = $rowcount";
			return $rowcount;
		}

		/***** runInsertQuery(query, recordArray, autoincrement value)
		* This function inserts one record into the specified
		*   table.  To use, pass in the prebuilt insert query, an array which holds
		*   the field names and field values. ['fieldname']=value.
		*   the first field in the array must be the primary key.
		*   this function assumes that the primary key is auto_increment
		*   unless you also pass in a false as the third parameter.  If
		*   you are working with an autoIncrement pk, then no third
		*   parameter is necessary.  If the file does have an auto_increment
		*   primary key, you must still pass in the pk field as the first
		*   value in the array - the pkfield value may be null.
		* This function returns the number of rows affected.  A zero
		*   implies that the function did not create the record.
		*
		* sample use:
		*   autoincrement pk: $result=insertRecord("customers",$array);
		*   not autoInc pk: $result=insertRecord("books",$array,false);
		*******************************************************/
		function runInsertQuery($query, $parm, $autoInc=true){
			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);
			println("");
			println("<br><br><h2>binding fields</h2>");
			//bind the fields
			$i=0;
			foreach($parm as $key => $field){
				/*this section replaced - add record now includes a null for autoincrement fields */
				//if($i==0 && $autoInc==true){
					//bind a null

					//$stmt->bindParam($i,"null");
				//}
				//else{
					if($i==0)
						$i++;
					$stmt->bindParam($i,$parm[$key]);
					echo "<br>bound: $i -> $parm[$key]";
				//}
				$i++;

			}
			//execute the query
			try{
				$stmt->execute();
			}
			catch(PDOException $e){
				print_r($stmt->errorInfo());
				echo "<br>DUMP PARAMS:";
				$stmt->debugDumpParams();
				$rowcount = 0;
				return $rowcount;
			}

			$rowcount = $stmt->rowCount();

			//echo "<br>rowcount = $rowcount";
			return $rowcount;
		}


		/***** updateRecord(tableName, recordArray, pkfield, pkvalue)
		* This function updates one record in the specified
		*   table.  To use, pass in the table name, an array which holds
		*   the field names and field values. ['fieldname']=value.  You
		*   must also provide the name of the primary key field and
		*   the value of the pk for the updated record.
		* This function returns the number of records affected.  If zero,
		*   then the record was not updated.
		*
		* sample use: $result=updateRecord("books",$array,"isbn",$isbn);
		*******************************************************/
		function updateRecord($table,$record,$pkfield,$pk){
			$pk = filter_var($pk,FILTER_SANITIZE_STRING);
			//get the book from the database
			$query = "update $table set ";
			$i=0;
			$qms="";
			$fieldset = "";
			foreach ($record as $key => $value){
				//echo "<br>record=".$value;
				if ($i==0)
					$qms = $qms." $key=?";
				else
					$qms = $qms.", $key=?";
				$i++;
			}
			$query .= $qms." WHERE $pkfield = ?";

			//echo "<br>query = $query";

			//create the pdo object
			$pdo = getPDO();
			//create the statement
			$stmt = $pdo->prepare($query);

			//bind the fields
			$i=0;
			//echo "<br>Binding parameters...";
			foreach($record as $key => $field){
				$i++;
				$stmt->bindParam($i,$record[$key]);
				//echo "<br>$i -> $record[$key]";
			}
			//bind the pk
			$i++;
			$stmt->bindParam($i,$pk);
			//echo "binding pk: $i -> $pk";
			//execute the query
			try{
				$stmt->execute();
			}
			catch(PDOException $e){
				echo "<br>Error saving data...";
				print_r($stmt->errorInfo());
				$rowcount = 0;
				return $rowcount;
			}
			$rowcount = $stmt->rowCount();
			//echo "<br>rowcount = $rowcount";
			return $rowcount;
		}

		/* buildInsertQuery( )******************************************************************
		 *       creates an insert query using a hashtable where hashtable[fieldname] = value
		 *******************************************************************************/
		function buildInsertQuery( $fd, $ht )
		{
			//must be ready to call insertRecord(tableName, recordArray, autoincrement value)
			print_r($fd);
			$table = $fd['table'];
			$pkAuto = $fd['pkAuto'];
			//$result = insertRecord($table, $ht, $pkAuto);
			//echo "Result = ".$result;

			$pkField = $fd['pk'];
			$fl = $fd['fieldList'];
			echo "<br>building insert query: pkfield = $pkField";
			$i=0;
			$query = "INSERT into ".$table." (";
			$flist = ") VALUES (";

			$first = 1;
			foreach( $ht as $key => $value)
			{


					echo "<br>building insert query: $key = $value";
					if( $key == 'postForm')
					{
						$temp= 1;
					}
					else
					{
						//add a comma if not the first field...
						if( $first < 1 )
						{
							$query = $query.", ";
							$flist = $flist.", ";
						}
						else
						{
							$first = 0;
						}
						//add the data
						$query = $query.$key;
						$flist = $flist."?";
						$i++;
						if($key == $pkField && $pkAuto == true){
							$param[$i] = "null";
						}
						else{
							$param[$i] = $value;
						}
						//$sa = $fl[ $key ];
						//if( $sa['num'] == false)
						//{
						//	$flist = $flist."'".$value."'";
						//}
						//else
						//{
						//	$flist = $flist.$value;
						//}
					} //end if key=postform
			} //end foreach

		    println("building insert query");

		  println("field list: ".$flist);

			$query = $query.$flist.") ";
		    println("query".$query);
			println("field list");
			print_r($param);

			$result = runInsertQuery($query,$param,$pkAuto);
			//println("finished product:".$query);

			return $result;
		}



		function quickButton($target, $caption )
		{
			//redirect to quickButtonL
			//$btnMicro = quickButtonL($target, $caption);
			$btnMicro = "<FORM class='linkbutton'>";
			$btnMicro .= "<INPUT TYPE='button' onclick=\"window.location='index.php?".$target."'\" value='".$caption."'>";
			$btnMicro .="</FORM>";
			return $btnMicro;
		}

			function quickButtonL( $target, $caption)
		{
			//$btnMicro = "<div class='linkbutton'>";
			//$btnMicro .= "<a href='index.php?".$target."'>".$caption."</a>";
			//$btnMicro .="</div>";
			return quickButton( $target, $caption);
		}

		function backButton($caption)
		{
			//$btnMicro = backButtonL($caption);
			$btnMicro = "<form class='linkbutton'><input type='button' onclick=\"window.location='index.php?p=back'\" value='".$caption."'></a></form>";
			return $btnMicro;
		}

		function backButtonL($caption)
		{
			//$btnMicro = "<div class='linkbutton'><a href='index.php?p=back'>".$caption."</a></div>";
			return backButton($caption);
		}

        function echoln($printline){
            echo $printline."<br>";
		}
?>