<!DOCTYPE html>
<html>
<!-- Name: Erin Ledford 
   EMAIL: eledford@unomaha.edu
   Class: BIOI 4870/CSCI 8876, Spring 2021 
   Assignment #: Final Project
 
   Honor Pledge: On my honor as a student of the University of Nebraska at 
   Omaha, I have neither given nor received unauthorized help on 
   this programming assignment.
 
   Partners: List the full names and e-mail addresses of everyone you may have 
   discussed the program with or worked on the program with. It is not necessary 
   to list your instructor. If none, state "NONE". NONE
 
   Sources: List all the sources you may have used for this assignment. It is 
   not necessary to list course content or manual pages, just internet 
   resources you looked up. If none, state "NONE." NCBI, Ensembl, Uniprot -->

<!-- MIT License

Copyright (c) [2020] [Erin Ledford]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.-->
<head>
<style>
body {
	margin: 0;
	font-family: Arial, Helvetica, sans-serif;
}

.sidenav {
	height: 100%;
	width: 200px;
	position: fixed;
	z-index: 1;
	top: 0;
	left: 0;
	background-color: #111;
	overflow-x: hidden;
}

.sidenav a {
	color: white;
	padding: 16px;
	text-decoration: none;
	display: block;
}

.sidenav a:hover {
	background-color: #ddd;
	color: blue;
}

.content {
	margin-left: 200px;
	padding-left: 20px;
	word-wrap: break-word;
}
</style>
</head>
<body>
<div class= "sidenav">
	<a href = "course_project_web.php">Home</a>
	<a href = "course_project_research_question.php">Research Question and Analysis</a>
	<a href = "course_project_FAQ.html">FAQ</a>
	<a href = "course_project_citations.html">Citations</a>
	<a href= "https://docs.google.com/forms/d/e/1FAIpQLSfd4YyYmzVjNzcfqEQxi7iXBk-YRU1lEy9615XSHMCgDnKR6w/viewform?usp=sf_link">Submit bugs and errors here</a>
</div>
<div class="content">
	<h1> Gene to Protein: Human Mitochondria Genes and Their Proteins</h1>
	<p>All data within this database is obtained from NCBI, Uniprot, and Ensembl.</p>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  	Enter a mitochondria gene ID: <input type="text" name="search">
  	<input type="submit">
	</form>


<!-- As far as I know this worked before the PHP broke.-->
<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
$search = "empty";

/*Process input from web user */  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $search = $_POST['search'];  		
    echo "<br>";
    if (empty($search)) {
        echo "No search term was provided, please try again.<br>";
    } else {
        echo "Search term provided was $search.<br>";
    } 
}

$server="localhost";
$username="eledford";
$password="";
$database="eledford";

/*Connect to my database
* and throw errors if its unable to connect.
* Greets the web user if it is able to connect.*/
$connect = mysqli_connect($server,$username,"",$database);

if($connect->connect_error){
	echo "Something has gone terribly wrong";
	echo "Connection error:" .$connect->connect_error;
}


/* Run a basic SQL query and throw
 * an error if its unable to perform the query
 */
$query = "SELECT genes.accession_number_gene, genes.gene_symbol, genes.full_name, genes.associated_protein, genes.organism, genes.last_updated, genes.location, genes.gene_type, genes.bp_length, genes.sequence, genes.num_associated_variants, proteins.accession_number_prot, proteins.full_name, proteins.associated_geneSymbol, proteins.organism, proteins.last_updated, proteins.location, proteins.aa_length, proteins.sequence FROM genes, proteins WHERE genes.accession_number_gene = \"". $search . "\" AND proteins.associated_geneSymbol = genes.gene_symbol ORDER BY accession_number_gene";
$result = mysqli_query($connect, $query) 
	  or trigger_error("Query Failed! SQL: $query - Error: "
	  . mysqli_error($connect), E_USER_ERROR);

/*If there are results from the query, print the 0th
 * token in the current tuple from the result relation
 * If there are no results, print an error message.
 */
if ($result = mysqli_query($connect, $query)) {
    while ($row = mysqli_fetch_row($result)) {
        printf("<br> Gene ID: %s", $row[0]);
	printf("<br> Gene symbol: %s", $row[1]);
	printf("<br> Full Name of this Gene: %s", $row[2]);
	printf("<br> Associated Protein Accession Number: %s", $row[3]);
	printf("<br> Organism: %s", $row[4]);
	printf("<br> Last updated: %s", $row[5]);
	printf("<br> Locus Location: %s", $row[6]);
	printf("<br> Gene Type: %s", $row[7]);
	printf("<br> Base Pair Length: %s", $row[8]);
	printf("<br> Number of Variants Associated with Disease: %s", $row[10]);
	printf("<br>");
	printf("<br> DNA Sequence: <br> %s", $row[9]);
	printf("<br><br> Protein Associated with this Gene: " %s, $row[11]);
	printf("<br> Full Name of this Protein: %s", $row[12]);
	printf("<br> Associated Gene Symbol for this Protein: %s", $row[13]);
	printf("<br> Organism: %s", $row[14]);
	printf("<br> Last updated: %s", $row[15]);
	printf("<br> Location of Protein in Mitochondria: %s", $row[16]);
	printf("<br> Amino Acid Length: %s", $row[17]);
	printf("<br> Protein Sequence: <br> %s", $row[18]);
    }
    mysqli_free_result($result);
}else{
	echo "No results";
}

/*Always close your connection. 
 * Its a courtesy to your fellow users.
 */
mysqli_close($connect);
?> 
</div>
</body> 
</html>
