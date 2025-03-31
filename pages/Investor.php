<?php
    include "../include/connect.php";

    if(isset($_COOKIE['vendor_id'])){
        header("Location: ../vendor/vendor_dashboard.php");
        exit;
    }
    
    if(isset($_COOKIE['adminEmail'])){
        header("Location: ../admin/dashboard.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Investors</title>
</head>
<body style="font-family: 'Outfit', sans-serif;">


    <!-- navbar -->
    <?php
        include "_navbar.php";
    ?>

    <div class="max-w-screen-lg m-auto px-6 py-12">
        <div class="title mb-8">
            <h1 class="text-6xl font-bold text-center">Investors</h1>
        </div>
        <div>
            <p class="text-lg font-medium mb-4">Investors in e-commerce sites play a pivotal role in shaping the success and growth of these digital businesses. Beyond providing crucial financial backing, they bring strategic insight and industry expertise that are instrumental in navigating the complexities of the online retail landscape.</p>
            <ul class="list-decimal ml-6 mb-6">
                <li class="mb-4">
                    <strong class="">Financial Backing:</strong>
                    <ul class="list-disc ml-6">
                        <li>Investors provide essential capital for operations, marketing, technology upgrades, and expansion efforts.</li>
                        <li>They participate in fundraising rounds to ensure ongoing financial stability and growth potential.</li>
                    </ul>
                </li>

                <li class="mb-4">
                    <strong>Strategic Guidance:</strong>
                    <ul class="list-disc ml-6">
                        <li>Drawing from their experience, investors offer strategic advice on market positioning, competitive strategies, and operational efficiencies.</li>
                        <li>They help set long-term goals and refine business strategies to achieve sustainable growth and profitability.</li>
                    </ul>
                </li>

                <li class="mb-4">
                    <strong>Network and Connections:</strong>
                    <ul class="list-disc ml-6">
                        <li>Investors leverage their extensive networks to forge valuable partnerships with suppliers, distributors, and potential collaborators.</li>
                        <li>They facilitate introductions to industry influencers and key players, opening doors for strategic alliances and market expansion.</li>
                    </ul>
                </li>

                <li class="mb-4">
                    <strong>Monitoring and Support:</strong>
                    <ul class="list-disc ml-6">
                        <li>Investors monitor key performance indicators (KPIs) and financial metrics to assess business health and progress towards milestones.</li>
                        <li>They provide ongoing support and guidance to management teams, ensuring alignment with strategic objectives and addressing challenges proactively.</li>
                    </ul>
                </li>

                <li class="mb-4">
                    <strong>Exit Strategy and Value Creation:</strong>
                    <ul class="list-disc ml-6">
                        <li>Investors work with management to develop and execute exit strategies, whether through acquisitions, IPOs, or strategic partnerships.</li>
                        <li>They focus on maximizing shareholder value by enhancing the company's market position and profitability over the long term.</li>
                    </ul>
                </li>
            </ul>
            <p class="text-lg font-medium">Ultimately, e-commerce investors contribute more than just financial resources; they bring a wealth of knowledge, connections, and strategic foresight that are essential for navigating the competitive e-commerce landscape and achieving sustainable growth.</p>
        </div>
    </div>
    
    <!-- footer -->
    <?php
        include "_footer.php";
    ?>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>
</html>