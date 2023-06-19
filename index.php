<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods in the store</title>
    <script>
        let ajax = new XMLHttpRequest();
        
        function vendor() {
            let vendor = document.getElementById("vendor").value;
            ajax.onreadystatechange = load1;
            
            ajax.open("GET", "getGoodsbyVen.php?vendor=" + vendor);
            ajax.send();
        }
        
        function load1() {
            if (ajax.readyState === 4 && ajax.status === 200) {
                document.getElementById("tabl1").innerHTML = ajax.responseText;
            }
        }
        
        function price() {
            let mnT = document.getElementById("start_price").value;
            let mxT = document.getElementById("end_price").value;
            ajax.onreadystatechange = load2;
            ajax.open("GET", "getGoodsbyPrice.php?start_price=" + mnT + "&end_price=" + mxT);
            ajax.send();
        }
        
        function load2() {
            if (ajax.readyState === 4 && ajax.status === 200) {
                let res2 = JSON.parse(ajax.responseText);
                let res21 = "";
                for (let i = 0; i < res2.length; i++) {
                    console.dir(res2[i]);
                    let name = res2[i].name;
                    let price = res2[i].price;
                    let items = res2[i].items;
                    res21 += "<b>Имя: </b>" + name + "<br><b>Цена: </b>" + price + "<br>";
                }
                document.getElementById("Result2").innerHTML = res21;
            }
        }
        
        function getGoodsbyCat(url, callback, format) {
    const ajax3 = new XMLHttpRequest();
    ajax3.onreadystatechange = function() {
        if (ajax3.readyState === 4 && ajax3.status === 200) {
            if (format === 'xml') {
                console.log("xml");
                callback(ajax3.responseXML);
            }           
        }
    };
    ajax3.open('GET', url);
    ajax3.send();   
}

function getGoodsbyCategory() {
    const category = document.getElementById('category').value;
    getGoodsbyCat('getGoodsbyCat.php?category=' + category, 
    function(response) {
        console.log(response);

        const items = response.getElementsByTagName('item');
        let tableRows = '';

        for (let i = 0; i < items.length; i++) {
            const c_name = items[i].getElementsByTagName('c_name')[0].textContent;
            const name = items[i].getElementsByTagName('name')[0].textContent;

            tableRows += `<tr><td>${c_name}</td><td>${name}</td></tr>`;
        }

        document.getElementById('res3').innerHTML = tableRows;
    },
    'xml');
}

    </script>
</head>
<body>
    
    <h2>Товари обраного виробника</h2>
        <select name="vendor" id="vendor">
    <?php
    include("connect.php");

    try 
    {
         foreach($dbh->query("SELECT DISTINCT v_name FROM vendors") as $row)
        {
            echo "<option value=$row[0]>$row[0]</option>";
        }
    }
    catch(PDOException $ex)
    {
        echo $ex->GetMessage();
    }
    ?>
    </select>
    <input type="submit" name="butt1" onclick="vendor()">
        <table border="1">
        <tr><th>Vendor Name</th><th>Item Name</th></tr>
            <tbody id="tabl1"></tbody>
        </table> 
    
<!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------->
<h2>Товари в обраної категорії</h2>
        <select name="category" id="category">
    <?php
    include("connect.php");
    try 
    {
         foreach($dbh->query("SELECT DISTINCT c_name FROM category") as $row)
        {
            echo "<option value=$row[0]>$row[0]</option>";
        }
    }
    catch(PDOException $ex)
    {
        echo $ex->GetMessage();
    }
    ?>
    </select>
        <input type="submit" value="Результат" onclick="getGoodsbyCategory()">
        <table border = '1'>
    <tbody id= "res3"></tbody>
    </table>



<!---------------------------------------------------------------------------------------------------------------------------->

<h2>Товари в обраному ціновому діапазоні</h2>
<form>
    <input type="number" name="start_price" id="start_price">
    <input type="number" name="end_price" id="end_price">
    <input type="button" value="Пошук" onclick="price()">
</form>
<div id="Result2"></div>

</body>
</html>

