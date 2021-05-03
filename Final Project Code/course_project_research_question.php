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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
img {
	display: block;
	margin-left: auto;
	margin-right: auto;
}
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
	<a href="course_project_web.php">Home</a>
	<a href="course_project_research_question.php">Research Question and Analysis</a>
	<a href="course_project_FAQ.html">FAQ</a>
	<a href= "course_project_citations.html">Citations</a>
	<a href= "https://docs.google.com/forms/d/e/1FAIpQLSfd4YyYmzVjNzcfqEQxi7iXBk-YRU1lEy9615XSHMCgDnKR6w/viewform?usp=sf_link">Submit bugs and errors here</a>
</div>
<div class="content">
	<h1>Research Question and Analysis</h1>
	<h2>How many mitochondria genes in the database have variants that lead to disease?</h2>
	<img src ="images/mitoPlot.png" 
	alt = "A graph of the number of variants per gene associated with disease"
	width="778" height="521">
	<h2>Genes and the highest amount of variants associated with one disease</h2>

<!--This PHP code worked before PHP broke. -->
<?php

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
$query = "SELECT accession_number_gene, gene_symbol, num_associated_variants, num_highest_variant, highest_disease_variant FROM genes ORDER BY accession_number_gene";
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
	printf("<br> Gene Symbol: %s", $row[1]);
	printf("<br> Total number of variants associated with disease and this gene: %s", $row[2]);
	printf("<br> Highest number of variants associated with one disease for this gene: %s", $row[3]);
	printf("<br> The disease with the highest number of variants associated with this gene: %s", $row[4]);
	printf("<br>");
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

	<h2>What is Leigh Syndrome?</h2>
	<p>According to NIH, leigh syndrome is a neurodegenerative disorder that develops in infancy or childhood. 
	This disorder may cause symptoms of vomiting, delayed development, seizures, muscle weakness, problems with movement,
	heart disease, kidney problems, and difficulty breathing. 
	The mitochondrial type of leigh syndrome can only be inherited maternally as only females 
	can pass on mitochondrial associated DNA.</p>

</div>
</body>
</html>