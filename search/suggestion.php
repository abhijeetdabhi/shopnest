<?php

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /shopnest/vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /shopnest/admin/dashboard.php");
    exit;
}

?>
<!-- Tailwind Script  -->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        /* Width of the scrollbar */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #A0AEC0;
        /* Color of the scrollbar thumb */
        border-radius: 10px;
        /* Rounded corners */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #4A5568;
        /* Darker color on hover */
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #F7FAFC;
        /* Background of the scrollbar track */
        border-radius: 10px;
        /* Rounded corners */
    }
</style>

<?php
include "../include/connect.php";

if (isset($_POST["query"])) {
    $output = "";
    $searchTerm = $_POST["query"];
    $mydata = mysqli_real_escape_string($con, $searchTerm);

    // Split search term into individual keywords for better matching
    $keywords = explode(' ', $mydata);

    // Build query for matching keywords (AND logic)
    $query = "SELECT * FROM products WHERE ";
    $queryParts = [];
    foreach ($keywords as $keyword) {
        $queryParts[] = "keywords LIKE '%" . $keyword . "%'"; // Match each keyword
    }
    $query .= implode(' AND ', $queryParts); // Combine parts using AND

    // Execute the query
    $result = mysqli_query($con, $query);

    // Output list items dynamically
    $output = '<ul class="max-h-60 overflow-y-auto border border-gray-300 bg-white rounded-b-lg shadow-lg custom-scrollbar">';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $keywordsArray = explode(',', $row['keywords']);
            foreach ($keywordsArray as $keyword) {
                $keyword = trim($keyword);
                if (!empty($keyword)) {
                    $encodedKey = urlencode($keyword);
                    $output .= '
                        <li id="suggestion" class="cursor-pointer hover:bg-gray-200 p-2 transition duration-150 ease-in-out">
                            <a href="/shopnest/search/search_items.php?searchName=' . $encodedKey . '" class="block text-gray-800">' . htmlspecialchars($keyword) . '</a>
                        </li>';
                }
            }
        }
    } else {
        $output .= "<li class='p-2 text-gray-500 text-center'>Product not found</li>";
    }

    $output .= "</ul>";
    echo $output;
}
?>