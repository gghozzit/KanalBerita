<?php
// Ambil data kategori dari database
$sql = "SELECT id, CategoryName FROM tblcategory";
$result = $con->query($sql);

// Bangun struktur HTML untuk dropdown
echo '<ul>';
while ($row = $result->fetch_assoc()) {
    echo '<li><a class="dropdown-item" href="#" data-id="' . $row['id'] . '">' . $row['CategoryName'] . '</a></li>';
}
echo '</ul>';
?>