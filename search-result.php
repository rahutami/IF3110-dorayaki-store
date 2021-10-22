<!DOCTYPE html>
<html lang='en'>

<?php 
    if(isset($_GET["query"])){
        $searchQuery = $_GET["query"];
    } else {
        $searchQuery = '';
    }
?>
<?php require_once('_header.php')?>

<body>
    <?php require_once('_navbar.php')?>

    <div class="container">
        <div class="page-btns">
            <button id="prev-page"><</button>
            <button id="next-page">></button>
        </div>

        <div id="dashboard-container">

         <input type="hidden" id="query-id" name="query-id" value="<?php echo $searchQuery?>">
        </div>
    </div>
</body>
        
    <script>
    let page = 1;

    const prevPage = document.getElementById('prev-page');
    prevPage.disabled = true;
    const nextPage = document.getElementById('next-page');

    prevPage.addEventListener('click', () => {
        page--;
        getSearchResult();
    })

    nextPage.addEventListener('click', () => {
        page++;
        getSearchResult();
    })
    
    let query = document.getElementById('query-id').value;

    function getSearchResult() {
        let container = document.getElementById("dashboard-container");
        console.log(query);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                let result = JSON.parse(this.responseText)

                if(result.length <= 5*page) nextPage.disabled = true;
                else nextPage.disabled = false;
                
                if(page === 1) prevPage.disabled = true;
                else prevPage.disabled = false;

                let stringResult = ''

                for (let i = 5*(page-1); i < 5*page; i++){
                    if(result[i] != undefined) stringResult += `
                    <div class='item'>
                        <a href='detail.php?id=${result[i]["id"]}'>
                        <img src='${result[i]["img_path"]}'>
                        <h2>${result[i]["name"]}</h2>
                <h3>Rp${result[i]["price"]}</h3>
            </a>
            </div>`
                }

                container.innerHTML = stringResult;
                // container.innerHTML = this.responseText;
                // console.log(this.responseText);
                console.log(result);
            }
        }
        xmlhttp.open("GET", "get-search-result.php?query=" + query, true);
        xmlhttp.send();
    }

    getSearchResult();
    </script>
</html>
