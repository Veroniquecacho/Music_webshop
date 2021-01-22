<?php 
session_start();


if (!isset($_SESSION['ACCESS'])) {  
    header('Location: index.php');
}

?>


<?php require_once('fragments/header.php') ?>
    <title>Mockify | Artist</title>
    <script src="./js/artist.js"></script>
    <script src="./js/script.js"></script>
</head>
<body>
    <header>
        <?php require_once('fragments/navigation.php') ?>
    </header>
    <main>
    
        <div class="search-container">
            <?php if($_SESSION['ACCESS'] === 'admin'){ ?> <svg width="24" height="24" class="trigger-btn add-artist" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>  <?php } ?>
            <form method="post" id="search-artist-form" class="search-form">
                <input type="text" name="search-input-artist" id="search-input-artist" placeholder="Search..">
                <input type="submit" value="Search">
            </form>
           

        </div>
        <section>
            <div class="page_navigation">
                <button id="prev-btn" page-id="-1" disabled="disabled">&#8249; Previous</button>
                <button id="next-btn" class="next-btn"page-id="1">Next &#8250;</button>
            </div>
            <section id="searched-artist">

            </section>
        </section>
    </main>
    <?php if($_SESSION['ACCESS'] === 'admin'){require_once('fragments/artist_modal.php');}?>
    
</body>
</html>