<?php
function generateProductKeywords($product) {
    $keywords = [];
    $category = strtolower($product['Category']); // Normalize category to lowercase

    // Title & Brand Keywords
    $keywords[] = $product['title'];
    $keywords[] = $product['company_name'] . ' ' . strtolower($product['Type']);
    $keywords[] = 'best ' . $product['company_name'] . ' ' . strtolower($product['Type']);
    $keywords[] = $product['title'] . ' for sale';


    if (strpos($category, 'phone') !== false || strpos($category, 'mobile') !== false) {
        // Keywords for phones
        $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " phone under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " smartphone";
        $keywords[] = $product['Type'] . " with best features";
        $keywords[] = "Best " . $product['company_name'] . " phone for " . $product['MRP'];
        $keywords[] = "Affordable " . $product['company_name'] . " phone";
        $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for sale";
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " for men";
        $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
        $keywords[] = "Buy " . $product['company_name'] . " phone under " . $product['MRP'];
        $keywords[] = "Latest " . $product['company_name'] . " smartphone for " . $product['Item_Condition'];
        $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for " . $product['MRP'];

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = "Best " . $product['company_name'] . " smartphone in " . $product['color'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
    } 
    elseif (strpos($category, 'tablet') !== false || strpos($category, 'ipad') !== false) {
        // Keywords for tablets
        $keywords[] = "Best tablet under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " tablet for sale";
        $keywords[] = "Buy " . $product['company_name'] . " tablet online";
        $keywords[] = "Affordable " . $product['company_name'] . " tablet";
        $keywords[] = $product['company_name'] . " tablet under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " tablet for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " tablet with features";
        $keywords[] = $product['company_name'] . " tablet for kids";
        $keywords[] = "Buy " . $product['company_name'] . " tablet for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " tablet for online classes";
        $keywords[] = $product['company_name'] . " tablet for students";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['Type'] . ' in ' . $product['color'];
            $keywords[] = "New " . $product['company_name'] . " tablet in " . $product['color'];
            $keywords[] = "Latest " . $product['company_name'] . " tablet in " . $product['color'];
            $keywords[] = "Stylish " . $product['company_name'] . " tablet in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['size'] . " Tablet";
            $keywords[] = "Best tablet in " . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'laptop') !== false || strpos($category, 'macbook') !== false) {
        // Keywords for laptops
        $keywords[] = "Best laptop under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " laptop with best features";
        $keywords[] = $product['company_name'] . " laptop sale";
        $keywords[] = "Buy " . $product['company_name'] . " laptop online";
        $keywords[] = "Best " . $product['company_name'] . " laptop for work";
        $keywords[] = $product['company_name'] . " laptop for students";
        $keywords[] = "Affordable " . $product['company_name'] . " laptop";
        $keywords[] = "Latest " . $product['company_name'] . " laptop for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " laptop for gaming";
        $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " laptop under " . $product['MRP'];
        $keywords[] = "Best " . $product['company_name'] . " laptop for office work";
        $keywords[] = "New " . $product['company_name'] . " laptop with features";
        $keywords[] = $product['company_name'] . " laptop for professional use";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['Type'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " laptop in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . " laptop with " . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'tv') !== false) {
        // Keywords for TV
        $keywords[] = "Best TV under " . $product['MRP'];
        $keywords[] = "4K " . $product['Type'] . " TV for sale";
        $keywords[] = "Buy " . $product['company_name'] . " TV online";
        $keywords[] = "Latest " . $product['company_name'] . " TV";
        $keywords[] = "Affordable " . $product['company_name'] . " TV";
        $keywords[] = $product['company_name'] . " TV under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " smart TV for sale";
        $keywords[] = "Best smart TV under " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " smart TV online";
        $keywords[] = $product['company_name'] . " LED TV under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " TV for home theater";
        $keywords[] = "Latest " . $product['company_name'] . " 4K TV for " . $product['MRP'];
        $keywords[] = "Best TV for watching movies";
        $keywords[] = "Stylish " . $product['company_name'] . " TV for your living room";


        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " TV in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Headphones') !== false) {
        // Keywords for Headphones
        $keywords[] = "Best " . $product['Type'] . " headphones under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " headphones for sale";
        $keywords[] = "Buy " . $product['company_name'] . " headphones online";
        $keywords[] = "Comfortable " . $product['company_name'] . " headphones";
        $keywords[] = "Best quality " . $product['company_name'] . " headphones";
        $keywords[] = "New " . $product['company_name'] . " headphones with features";
        $keywords[] = $product['company_name'] . " noise-cancelling headphones";
        $keywords[] = "Affordable " . $product['company_name'] . " headphones";
        $keywords[] = $product['company_name'] . " sports headphones";
        $keywords[] = $product['company_name'] . " Bluetooth headphones under " . $product['MRP'];
        $keywords[] = "Stylish " . $product['company_name'] . " headphones for men";
        $keywords[] = "Latest " . $product['company_name'] . " headphones for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " headphones for gaming";
        
        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['type'] . " headphones in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Earphones') !== false) {
        // Keywords for Earphones
        $keywords[] = "Best " . $product['Type'] . " earphones under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " earphones for sale";
        $keywords[] = "Buy " . $product['company_name'] . " earphones online";
        $keywords[] = "Affordable " . $product['company_name'] . " earphones";
        $keywords[] = $product['company_name'] . " Bluetooth earphones";
        $keywords[] = "New " . $product['company_name'] . " earphones with features";
        $keywords[] = $product['company_name'] . " wireless earphones under " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " earphones for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " earphones for workouts";
        $keywords[] = "Best " . $product['company_name'] . " earphones for music";
        $keywords[] = "Comfortable " . $product['company_name'] . " earphones for men";
        $keywords[] = "Latest " . $product['company_name'] . " earphones for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " earphones for kids";
        $keywords[] = $product['company_name'] . " noise-cancelling earphones";


        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = "Stylish " . $product['company_name'] . " earphones in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Watches') !== false) {
        // Keywords for Watch
        $keywords[] = "Best " . $product['company_name'] . " watch under " . $product['MRP'];
        $keywords[] = "Stylish " . $product['company_name'] . " watch for men";
        $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " watch online";
        $keywords[] = $product['company_name'] . " wristwatch for sale";
        $keywords[] = "New " . $product['company_name'] . " watch with features";
        $keywords[] = "Affordable " . $product['company_name'] . " watch";
        $keywords[] = $product['company_name'] . " luxury watch under " . $product['MRP'];
        $keywords[] = "Best watch for " . $product['size'] . " wrists";
        $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " watch online";
        $keywords[] = $product['company_name'] . " men's watch for casual wear";
        $keywords[] = $product['company_name'] . " smartwatch for fitness";
        $keywords[] = "Latest " . $product['company_name'] . " watch for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " watch with best features";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " watch in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'shoes') !== false) {
        // Keywords for Shoes
        $keywords[] = $product['company_name'] . " shoes under " . $product['MRP'];
        $keywords[] = "Best " . $product['company_name'] . " shoes";
        $keywords[] = "Buy " . $product['company_name'] . " shoes online";
        $keywords[] = "Stylish " . $product['company_name'] . " shoes";
        $keywords[] = "Comfortable " . $product['company_name'] . " shoes";
        $keywords[] = "Buy " . $product['company_name'] . " shoes for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " shoes for casual wear";
        $keywords[] = "Trendy " . $product['company_name'] . " shoes for men";
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " shoes under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " shoes for everyday use";
        $keywords[] = "Best " . $product['company_name'] . " shoes for running";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " shoes in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
            $keywords[] = "Affordable " . $product['company_name'] . " shoes in " . $product['size'];
            $keywords[] = "Latest " . $product['company_name'] . " shoes for " . $product['size'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " shoes for " . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'clothes') !== false || strpos($category, 'clothing') !== false) {
        // Keywords for clothes    
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "Best " . $product['Type'] . " for " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
        $keywords[] = "Affordable " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " latest collection";
        $keywords[] = "Top " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "Buy " . $product['Type'] . " online with discounts";
        $keywords[] = "Trendy " . $product['Type'] . " from " . $product['company_name'];
        $keywords[] = "Shop for " . $product['Type'] . " online now";
        $keywords[] = $product['Type'] . " from " . $product['company_name'] . " at best price";
        $keywords[] = "Stylish " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "New arrivals in " . $product['Type'];
        $keywords[] = "Buy " . $product['Type'] . " online in India";
        $keywords[] = "Exclusive deals on " . $product['company_name'] . " " . $product['Type'];
        
        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " online";
            $keywords[] = "Latest " . $product['Type'] . " from " . $product['company_name'] . " in " . $product['color'];
            $keywords[] = $product['Type'] . " in " . $product['color'] . " from " . $product['company_name'];
            $keywords[] = "Stylish " . $product['Type'] . " in " . $product['color'] . " under " . $product['MRP'];
            $keywords[] = "Buy " . $product['Type'] . " online in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
            $keywords[] = "Best " . $product['Type'] . " in " . $product['size'] . " size for " . $product['MRP'];
            $keywords[] = "Affordable " . $product['Type'] . " in " . $product['size'] . " size under " . $product['MRP'];
            $keywords[] = "Trendy " . $product['Type'] . " for " . $product['MRP'] . " in " . $product['size'];
            $keywords[] = "Shop " . $product['size'] . " size " . $product['Type'] . " online";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['size'] . " for " . $product['MRP'];
            $keywords[] = "Exclusive " . $product['Type'] . " in " . $product['size'] . " size online";
            $keywords[] = "Top " . $product['Type'] . " in " . $product['size'] . " size under " . $product['MRP'];
            $keywords[] = "Fashionable " . $product['Type'] . " in " . $product['color'] . " and " . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'camera') !== false) {
        // Keywords for Cameras
        $keywords[] = $product['company_name'] . " camera under " . $product['MRP'];
        $keywords[] = "Best " . $product['Type'] . " camera for " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " camera online";
        $keywords[] = "Latest " . $product['company_name'] . " camera for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " DSLR camera for sale";
        $keywords[] = $product['company_name'] . " camera with best features";
        $keywords[] = $product['company_name'] . " mirrorless camera under " . $product['MRP'];
        $keywords[] = "Affordable " . $product['company_name'] . " camera";
        $keywords[] = "New " . $product['company_name'] . " camera with features";
        $keywords[] = "Best " . $product['company_name'] . " camera for travel";
        $keywords[] = $product['company_name'] . " camera for photography";
        $keywords[] = "Buy " . $product['company_name'] . " camera for video recording";
        $keywords[] = $product['company_name'] . " camera with wide-angle lens";
        $keywords[] = $product['company_name'] . " camera for professional use";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " camera in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Electronics item') !== false) {
        // Keywords for Toys
        $keywords[] = "Best electronics under " . $product['MRP'];
        $keywords[] = "Affordable " . $product['company_name'] . " electronics";
        $keywords[] = "Buy " . $product['company_name'] . " electronics online";
        $keywords[] = "Latest " . $product['company_name'] . " electronics for sale";
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " electronics for " . $product['MRP'];
        $keywords[] = "Best quality electronics under " . $product['MRP'];
        $keywords[] = "New " . $product['company_name'] . " electronics with features";
        $keywords[] = $product['company_name'] . " electronics for home use";
        $keywords[] = $product['company_name'] . " electronics for office";
        $keywords[] = "Buy " . $product['company_name'] . " electronics for " . $product['Item_Condition'];
        $keywords[] = "Latest " . $product['company_name'] . " gadgets for sale";
        $keywords[] = "Affordable " . $product['company_name'] . " gadgets online";
        $keywords[] = $product['company_name'] . " tech gadgets for home";
        $keywords[] = "Best " . $product['company_name'] . " electronics";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " electronics in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Tech accessories') !== false) {
        // Keywords for Tech accessories
        $keywords[] = "Best " . $product['company_name'] . " tech accessories under " . $product['MRP'];
        $keywords[] = "Affordable " . $product['company_name'] . " tech accessories";
        $keywords[] = "Buy " . $product['company_name'] . " tech accessories online";
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " tech accessories";
        $keywords[] = "Latest " . $product['company_name'] . " tech gadgets";
        $keywords[] = $product['company_name'] . " accessories";
        $keywords[] = "Best " . $product['company_name'] . " accessories";
        $keywords[] = "New " . $product['company_name'] . " tech accessories";
        $keywords[] = $product['company_name'] . " headphones and accessories";
        $keywords[] = $product['company_name'] . " laptop accessories for " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " tech accessories for " . $product['Item_Condition'];

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            $keywords[] = $product['company_name'] . " tech accessories in " . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Game item') !== false) {
        // Keywords for Game item
        $keywords[] = "Best game items under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " gaming accessories for sale";
        $keywords[] = "Buy " . $product['company_name'] . " game item online";
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " game item for " . $product['MRP'];
        $keywords[] = "Latest " . $product['company_name'] . " gaming gear";
        $keywords[] = "Affordable " . $product['company_name'] . " game accessories";
        $keywords[] = "New " . $product['company_name'] . " game item for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " game controllers for sale";
        $keywords[] = "Buy " . $product['company_name'] . " gaming headset for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " game items for PS5";
        $keywords[] = "Best gaming console for " . $product['MRP'];
        $keywords[] = "Latest " . $product['company_name'] . " game items for " . $product['MRP'];
        $keywords[] = $product['company_name'] . " gaming items for competitive gaming";
        $keywords[] = "Best " . $product['company_name'] . " game accessories for streamers";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'Kitchen') !== false) {
        // Keywords for Kitchen
        $keywords[] = "Best kitchen items under " . $product['MRP'];
        $keywords[] = $product['company_name'] . " kitchen appliances for sale";
        $keywords[] = "Buy " . $product['company_name'] . " kitchen items online";
        $keywords[] = "New " . $product['company_name'] . " kitchen gadgets";
        $keywords[] = $product['company_name'] . " kitchen utensils for " . $product['MRP'];
        $keywords[] = "Affordable " . $product['company_name'] . " kitchen accessories";
        $keywords[] = "Latest " . $product['company_name'] . " kitchen products";
        $keywords[] = $product['company_name'] . " kitchen tools for " . $product['Item_Condition'];
        $keywords[] = $product['company_name'] . " cooking gadgets for sale";
        $keywords[] = "Best " . $product['company_name'] . " kitchen tools";
        $keywords[] = $product['company_name'] . " kitchen appliances for home use";
        $keywords[] = $product['company_name'] . " kitchen accessories for professionals";
        $keywords[] = "Best " . $product['company_name'] . " cooking items for gifting";
        $keywords[] = $product['company_name'] . " smart kitchen appliances";
        $keywords[] = $product['company_name'] . " kitchen products under " . $product['MRP'];

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'furniture') !== false) {
        // Keywords for Furniture
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " furniture under " . $product['MRP'];
        $keywords[] = "Best " . $product['Type'] . " furniture for " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " furniture online";
        $keywords[] = "Top " . $product['Type'] . " furniture at best prices";
        $keywords[] = "Affordable " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "Modern " . $product['Type'] . " furniture for your home";
        $keywords[] = "Latest " . $product['Type'] . " furniture from " . $product['company_name'];
        $keywords[] = "Premium " . $product['Type'] . " furniture online";
        $keywords[] = $product['Type'] . " for " . $product['MRP'] . " by " . $product['company_name'];
        $keywords[] = "Best deals on " . $product['company_name'] . " " . $product['Type'];
        $keywords[] = "Stylish " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "Shop for " . $product['Type'] . " furniture now";
        $keywords[] = "Buy " . $product['Type'] . " furniture online in India";
        $keywords[] = "Exclusive offers on " . $product['company_name'] . " furniture";

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 
    elseif (strpos($category, 'toys') !== false) {
        // Keywords for Toys
        $keywords[] = $product['company_name'] . " " . $product['Type'] . " toys under " . $product['MRP'];
        $keywords[] = "Best " . $product['Type'] . " toys for " . $product['MRP'];
        $keywords[] = "Buy " . $product['company_name'] . " toys online";
        $keywords[] = "Affordable " . $product['Type'] . " under " . $product['MRP'];
        $keywords[] = "Top-rated " . $product['Type'] . " toys online";
        $keywords[] = "Latest " . $product['Type'] . " from " . $product['company_name'];
        $keywords[] = "Shop " . $product['Type'] . " for kids under " . $product['MRP'];
        $keywords[] = "Premium quality " . $product['Type'] . " toys online";
        $keywords[] = "Trending " . $product['Type'] . " for " . $product['MRP'];
        $keywords[] = $product['Type'] . " gifts for kids under " . $product['MRP'];
        $keywords[] = "Fun " . $product['Type'] . " toys by " . $product['company_name'];
        $keywords[] = "Shop for " . $product['Type'] . " toys now";
        $keywords[] = "Buy " . $product['Type'] . " online with discounts";
        $keywords[] = "Exclusive offers on " . $product['company_name'] . " " . $product['Type'];

        // Color Keywords
        if (isset($product['color'])) {
            $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
        }

        // Size Keywords (if applicable)
        if (isset($product['size'])) {
            $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
            $keywords[] = $product['title'] . ' ' . $product['size'];
        }
        
    } 

    return array_unique($keywords);
}

// Example product for testing
$product = [
    'title' => 'LG 7 Kg` 5 Star` Direct Drive Technology` Steam Wash` 6 Motion DD` Smart Diagnosis` Fully-Automatic Front Load Washing Machine (FHM1207SDM` Allergy Care` In-Built Heater` Touch Panel` Middle Black)',
    'company_name' => 'LG',
    'Category' => 'Electronics item',
    'Type' => "Washing Machine",
    'MRP' => '28,990',
    'Item_Condition' => 'New',
    'color' => 'Black',
    'size' => '7 KG'
];

// Generate keywords
$keywords = generateProductKeywords($product);
echo "<pre>";
print_r($keywords);
echo "</pre>";

?>