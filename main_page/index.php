<?php include '../conn.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combri</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--rating-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style_const.css">
    <link rel="stylesheet" href="nav.css">

</head>

<body>
  <nav id="navbar" class="nav">
    <div class="navbar">
      <i class="bx bx-menu"></i>
      <div class="logo"><a href="#">ComBri</a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name">ComBri</span>
          <i class="bx bx-x"></i>
        </div>
        <ul class="links">
          <li><a href="../profile/profile.php#my_profile">Profile</a></li>
          <li><a href="index.php" >Home</a></li>
          <li><a href="index-about_use.php">About us</a></li>
        </ul>
      </div>
      
      <div class="nav-links">
        <ul class="links">
          <li>
            <div class="search-box">
              <a href="index-search.php">
              <i class="bx bx-search"></i>
              </a>
            </div>
          </li>
          <?php
            session_start();
            if (isset($_SESSION['username'])) {
              $username = $_SESSION['username']; 
              echo "<li><a href='../profile/profile.php'>$username</a></li>";
            } else {
                echo "<li><a href='../profile/profile.php'>Combri</a></li>";
            }
          ?>
<li style="top: 13px;">
  <a href="../profile/profile.php#my_profile">
    <img src="https://i.kinja-img.com/gawker-media/image/upload/gd8ljenaeahpn0wslmlz.jpg" class="image-profile">
  </a>
</li>
        </ul>
      </div>
    </div>
  </nav>
  
  
    <div class="notice">
      <img class="notice_img" src="img/NOTICE_1_example.jpg"  alt="" height="40vh">
      <img class="notice_img" src="img/NOTICE_2_example.webp" alt="" height="40vh">
      <script src="notice_script.js"></script>
    </div>
    
  <div class="category">
    <div class="category-chooser">
      <button onclick="categoryOnClick()" style="margin-left: 0px;" class="kategori dark-bg">Trending</button>
      <button onclick="categoryOnClick()" class="kategori dark-bg">Top Rated</button>
      <button onclick="categoryOnClick()" class="kategori dark-bg">Most Viewed</button>
    </div>

    <div class="card-section dark-bg">
      <!-- Category Sections -->
      <section class="companyName-cardSelector">
        <?php
          $query = "SELECT * FROM posters";
          $stmt = $pdo->prepare($query);
          $stmt->execute();
          $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($category as $index => $item): 
            $h3 = $item['company_name'];
            $img = $item['poster_img'];
          endforeach;

          // $query = "
          //   SELECT 
          //     SUBSTRING_INDEX(SUBSTRING_INDEX(unique_id, '102', 1), '101', -1) AS general,
          //     SUBSTRING_INDEX(unique_id, '102', -1) AS specific
          //   FROM posters";
          // $stmt = $pdo->prepare($query);
          // $stmt->execute();
          // $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          
          $query = "SELECT COUNT(*) AS total FROM posters WHERE unique_id LIKE ?";
          $stmt = $pdo->prepare($query);
          $stmt->execute(['%laptop%']);
          $total = $stmt->fetch(PDO::FETCH_ASSOC);

          $kriteria = array("Laptop","Smartphone","Tablet", "Iphone", "TV", "Car", "Bike", "Foot Ball");
          $len = count($kriteria);

        ?>

        <script>
          // Temporary While
          let kriteria = <?php echo json_encode($kriteria); ?>;
  let posters = <?php echo json_encode($category); ?>;
  let totalPosters = <?php echo json_encode($total['total']); ?>;
  
  const companyName_class = document.querySelector(".companyName-cardSelector");

  // Function to auto-generate the cards
  function auto_add_card() {
  // Loop through each category in the kriteria array
  kriteria.forEach((category, i) => {
    let section_html = `
      <h1>${category}</h1>
      <div class="card-overflow" id="${category}">`;

    let cards = "";

    // Loop through all posters and generate the card HTML
    posters.forEach((poster, j) => {
      // Generate card for each poster
      cards += `
        <div class="card">
          <div class="card-image" style="background-image: url('${poster.poster_img}');"></div>
          <div class="card-content">
            <h3>${poster.company_name} 
              <p style="float: inline-end; font-size: small;" class="description">20</p>
            </h3>
            <p class="description">Views: 0</p>
            
            <div class="stars">
              <span class="fa fa-star bintang-rating" id="${category}00${j}-ST1"></span>
              <span class="fa fa-star bintang-rating" id="${category}00${j}-ST2"></span>
              <span class="fa fa-star bintang-rating" id="${category}00${j}-ST3"></span>
              <span class="fa fa-star bintang-rating" id="${category}00${j}-ST4"></span>
              <span class="fa fa-star bintang-rating" id="${category}00${j}-ST5"></span>
            </div>
          </div>

          <div class="card-footer">
            <button class="button">
              &rarr;
            </button>
          </div>
        </div>`;
    });

    // Close the card overflow container
    section_html += cards + "</div>";
    
    // Add this section to the page
    companyName_class.innerHTML += section_html;
  });
  star_responsive();
}

          auto_add_card()
          </script>
        <!-- <h1>Laptops</h1>
        <div class="card-overflow" id="Laptops">
          <div class="card">
            <div class="card-image" style="background-image: url('img/Logo_asus.png');"></div>
            <div class="card-content">
              <h3>ASUS <p style="float: inline-end; font-size: small;" class="description">20</p></h3>
              <p class="description">Views: 0</p>
              
              <div class="stars">
                <span class="fa fa-star bintang-rating" id="asus001-ST1"></span>
                <span class="fa fa-star bintang-rating" id="asus001-ST2"></span>
                <span class="fa fa-star bintang-rating" id="asus001-ST3"></span>
                <span class="fa fa-star bintang-rating" id="asus001-ST4"></span>
                <span class="fa fa-star bintang-rating" id="asus001-ST5"></span>
              </div>
            </div>
            
            <div class="card-footer">
              <button class="button">
                &rarr;
              </button>
            </div>
          </div>

          <div class="card">
            <div class="card-image" style="background-image: url('img/Logo_huawei.png');"></div>
            <div class="card-content">
              <h3>HUAWEI <p style="float: inline-end; font-size: small;" class="description">20</p></h3>
              <p class="description">Views: 0</p>
                
              <div class="stars">
                <span class="fa fa-star bintang-rating" id="huawei001-ST1"></span>
                <span class="fa fa-star bintang-rating" id="huawei001-ST2"></span>
                <span class="fa fa-star bintang-rating" id="huawei001-ST3"></span>
                <span class="fa fa-star bintang-rating" id="huawei001-ST4"></span>
                <span class="fa fa-star bintang-rating" id="huawei001-ST5"></span>
              </div>
            </div>

            <div class="card-footer">
              <button class="button">
                &rarr;
              </button>
            </div>

          </div>
        </div> -->
      </section>

      <!-- <section class="companyName-cardSelector">
        <h1>Smartphones</h1>
        <div class="card-overflow">
          <div class="card">
            <div class="card-image" style="background-image: url('img/Logo_asus.png');"></div>
            <div class="card-content">
                <h3>ASUS <p style="float: inline-end; font-size: small;" class="description">20</p></h3>
                <p class="description">Views: 0</p>
              
                <div class="stars">
                  <span class="fa fa-star bintang-rating" id="asus002-ST1"></span>
                  <span class="fa fa-star bintang-rating" id="asus002-ST2"></span>
                  <span class="fa fa-star bintang-rating" id="asus002-ST3"></span>
                  <span class="fa fa-star bintang-rating" id="asus002-ST4"></span>
                  <span class="fa fa-star bintang-rating" id="asus002-ST5"></span>
                </div>
            </div>
        
            <div class="card-footer">
                <button class="button">
                  &rarr;
                </button>
            </div>
          </div>
        </div>
      </section> -->

    </div>
  </div>

<!-- Footer -->
  <footer class="footerContainer">
    <div class="socialIcons">
      <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
      <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
      <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
      <a href="#" aria-label="Google Plus"><i class="fa-brands fa-google-plus"></i></a>
      <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
    </div>

    <div class="footerNav">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">News</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Our Team</a></li>
      </ul>
    </div>

    <div class="footerBottom">
      <p>&copy; 2024 ComBri.com. All rights reserved.</p>
    </div>
  </footer>
    
  <script src="script.js"></script>
</body>
</html>