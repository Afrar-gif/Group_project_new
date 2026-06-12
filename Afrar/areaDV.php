<?php
include "db.php";

$sql = "SELECT * FROM areas ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>View Areas</title>

<style>
body{
    font-family: Arial;
    background:#173845;
    padding:20px;
}

h1{
    text-align:center;
    color:white;
    margin-bottom:20px;
}

/* FILTER BOX */
.filter-box{
    display:flex;
    gap:10px;
    justify-content:center;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.filter-box input{
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
    width:220px;
    outline:none;
}

.filter-box input:focus{
    border-color:#0077b6;
    box-shadow:0 0 5px rgba(0,119,182,0.3);
}

/* TABLE */
.table-container{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    min-width:700px;
}

th{
    background:#0077b6;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:nth-child(even){
    background:#f2f2f2;
}

.data-row:hover{
    background:#e3f2fd;
}

/* NO DATA */
.no-data{
    text-align:center;
    padding:20px;
    color:white;
}

/* NAANE ADD SEITHA GREEN ACTION BUTTON STYLE */
.action-btn {
    background-color: #10b981;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    display: inline-block;
}
.action-btn:hover {
    background-color: #059669;
}

@media(max-width:768px){
    table{
        min-width:100%;
    }
}
</style>
</head>

<body>

<h1>Area Details</h1>

<div class="filter-box">
    <input type="text" id="districtFilter" placeholder="Search District">
    <input type="text" id="cityFilter" placeholder="Search City">
    <input type="text" id="areaFilter" placeholder="Search Area">
</div>

<div class="table-container">
<table>
<tr>
    <th>ID</th>
    <th>District</th>
    <th>City</th>
    <th>Area</th>
    <th>Transformer</th>
    <th>Action</th> </tr>

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

<tr class="data-row">
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['district']; ?></td>
    <td><?php echo $row['city']; ?></td>
    <td><?php echo $row['area']; ?></td>
    <td><?php echo $row['transformer']; ?></td>
    <td>
        <a href="create_alert.php?id=<?php echo $row['id']; ?>&area=<?php echo urlencode($row['area']); ?>" class="action-btn">
            ➕ Schedule Alert
        </a>
    </td>
</tr>

<?php
    }
} else {
    // Colspan column adathirkaha 6 aaha maatriyullen
    echo "<tr><td colspan='6' class='no-data'>No Data Found</td></tr>";
}
?>
</table>
</div>

<script>
let districtInput = document.getElementById("districtFilter");
let cityInput = document.getElementById("cityFilter");
let areaInput = document.getElementById("areaFilter");

let rows = document.getElementsByClassName("data-row");

function filterTable(){
    let d = districtInput.value.toLowerCase();
    let c = cityInput.value.toLowerCase();
    let a = areaInput.value.toLowerCase();

    for(let i=0; i<rows.length; i++){
        let district = rows[i].children[1].innerText.toLowerCase();
        let city = rows[i].children[2].innerText.toLowerCase();
        let area = rows[i].children[3].innerText.toLowerCase();

        if(
            district.includes(d) &&
            city.includes(c) &&
            area.includes(a)
        ){
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

districtInput.addEventListener("keyup", filterTable);
cityInput.addEventListener("keyup", filterTable);
areaInput.addEventListener("keyup", filterTable);
</script>

</body>
</html>