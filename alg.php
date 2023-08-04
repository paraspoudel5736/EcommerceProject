<?php
// Connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User's preferred tag (for example, retrieved from user's profile or preferences)
$preferredTag = "your_preferred_tag";

// Fetch videos that match the user's preferred tag
$sql = "SELECT * FROM product WHERE description like '$preferredTag'%";
$result = $conn->query($sql);

// Array to store recommended videos
$recommendedVideos = array();

// Check if there are any videos that match the preferred tag
if ($result->num_rows > 0) {
    // Loop through each video and calculate similarity scores
    while ($row = $result->fetch_assoc()) {
        $videoId = $row["id"];
        $videoTitle = $row["name"];
        $videoDescription = $row["description"];
        $videoTag = $row["meta_tag"];
        $videoFile = $row["videoFile"];

        // Calculate similarity score based on video attributes (you can define your own similarity metric)
        $similarityScore = calculateSimilarity($videoTitle, $videoDescription, $preferredTag);

        // Store video details along with similarity score in the recommendedVideos array
        $recommendedVideos[] = array(
            "videoId" => $videoId,
            "videoTitle" => $videoTitle,
            "videoDescription" => $videoDescription,
            "tag" => $videoTag,
            "videoFile" => $videoFile,
            "similarityScore" => $similarityScore,
        );
    }

    // Sort recommended videos based on similarity score in descending order
    usort($recommendedVideos, function ($a, $b) {
        return $b["similarityScore"] <=> $a["similarityScore"];
    });

    // Display the recommended videos
    foreach ($recommendedVideos as $video) {
        echo "<div>";
        echo "<h2>" . $video["videoTitle"] . "</h2>";
        echo "<p>" . $video["videoDescription"] . "</p>";
        echo "<video controls><source src='" . $video["videoFile"] . "' type='video/mp4'></video>";
        echo "</div>";
    }
} else {
    echo "No videos found matching your preferred tag.";
}

// Close the database connection
$conn->close();

// Function to calculate similarity score (you can implement your own similarity metric)
function calculateSimilarity($videoTitle, $videoDescription, $preferredTag) {
    // Implement your own similarity calculation based on video attributes and the user's preferred tag
    // For example, you can use cosine similarity, Jaccard similarity, etc.
    // For simplicity, we'll just return a random similarity score in this example.
    return rand(1, 10);
}
?>
<!-- your code -->
<div class="container"> 
            <div class="row">
                <div class="row">
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <div class="mt-5" style="
                    text-align: center;
                    text: 25px;
                    font-size: 30px;
                    font-weight: bold;">
                        Related Products
                    </div>
                </div>
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <?php
                 
                    foreach($get_related_product as $list){
                    ?>
                    <!-- Start Single Category -->
                    <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                        <div class="category">
                            <div class="ht__cat__thumb">
                                <a href="product.php?id=<?php echo $list['id']?>">
                                <img src="media/product/<?php echo $list['image']?>" alt="full-image"/>
                                </a>
                            </div>
                            
                            <div class="fr__product__inner">
                                <h4><a href="product-details.html"><?php echo $list['name']?></a></h4>
                                <ul class="fr__pro__prize">
                                    <li>Rs. <?php echo $list['price']?></li>
                                  
                                    
                                    
                                </ul>
                                <li><?php echo $list['meta_tag']?></li>
                            </div>
                        </div>
                    </div>
                    <?php 
                  
                } ?>
            </div>
        </div>
