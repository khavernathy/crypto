<?php
    if (isset($_GET['save'])) {
        //echo 'saving.';

        $thefilecontents = "";

        foreach($_POST as $key => $value)
        {
            if (strstr($key, '_name') || strstr($key, 'NEWNAME')) {
                //echo $key.' => '.$value.'<br />'; 
                if (strstr($key, '_name'))
                    $thefilecontents = $thefilecontents.$value."    ".$_POST[$value.'_value']."    ".$_POST[$value.'_url'].PHP_EOL;
                else if (strstr($key, 'NEWNAME')) {
                    $thefilecontents = $thefilecontents.$value."    ".$_POST['NEWHOLDING']."    ".$_POST['NEWURL'].PHP_EOL;
                }
            }
        }

        //echo '<br /><br />';
        //echo $thefilecontents;

        file_put_contents("assets.txt", $thefilecontents);
    }
        

?>

<html>
  <head>
    
    <title>Doug's Crypto</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="./jquery.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      
        function drawChart() {

            var Coins = ["crypto"];    

            // READ IN CRYPTOS FOR THIS PERSON'S assets.txt
            var rawFile = new XMLHttpRequest();
            file = "assets.txt";
            rawFile.open("GET", file, false);
            rawFile.onreadystatechange = function ()
            {
                if(rawFile.readyState === 4)
                {
                    if(rawFile.status === 200 || rawFile.status == 0)
                    {
                        var allText = rawFile.responseText;
                        unique_holdings = allText.split('\n');
                        
                        var thelength = unique_holdings.length;
                        for (i=0; i<thelength; i++) {
                            if (unique_holdings[i] == "") continue;
                            columns = unique_holdings[i].split(/[ ,]+/);
                            Coins.push(columns[0]); 
                        }
                    }
                }
                display = display + '</table><input type="submit" value="save assets" /><input type="button" onclick="addNewRow();" value="add new" /></form>';
                document.getElementById("right_form").innerHTML = display;   
            }
            rawFile.send(null);


        // add a lot of colors later (so user can have inf coinz)
        var Colors = ['#e432b1', '#4de32a', '#28cae1', 
                    '#f477dc', '#fbf230', '#000000', 
                    '#ff0000', '#00ff00', '#0000ff',
                    '#eeeeee', '#ff0000' ];

        for (x=0; x < Coins.length; x++) {
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'Time of Day');
        data.addColumn('number', Coins[x]);

        var rawFile = new XMLHttpRequest();
        file = Coins[x]+".txt";
        rawFile.open("GET", file, false);
        rawFile.onreadystatechange = function ()
        {
            if(rawFile.readyState === 4)
            {
                if(rawFile.status === 200 || rawFile.status == 0)
                {
                    var allText = rawFile.responseText;
                    //alert(allText);
                    var lineArr = allText.split('\n');
                    
                    // skipping first row (header row)
                    for (i=1; i < lineArr.length; i++) {
                        if (lineArr[i] == "") continue;
                        //console.log("this line: "+ lineArr[i]);
                        thisLineArr = lineArr[i].split('    '); // thisLineArr 0,1 are two columns
                        dateTime = thisLineArr[0].split('T'); // dateTime 0, 1 are date and time
                        //console.log("dateTime 0 = "+dateTime[0]+"; dateTime 1 = "+dateTime[1]);
        
                        dateParts = dateTime[0].split('-'); // dateParts 0,1,2 are Y,M,D
                        timeParts = dateTime[1].split(':'); // timeParts 0,1,2 are h,m, s.999
                        timeParts[2].replace(".999",""); // get rid of .999 format thing for seconds

                        Y = parseInt(dateParts[0]); 
                        M = parseInt(dateParts[1])-1; // -1 bc google month starts at 0 
                        D = parseInt(dateParts[2]);
                        h = parseInt(timeParts[0]); 
                        m = parseInt(timeParts[1]); 
                        s = parseInt(timeParts[2]);
                        value = parseFloat(thisLineArr[1]);
                        //console.log(Y+" "+M+" "+D+" "+h+" "+m+ " "+ s);

                        data.addRow([new Date(Y,M,D,h,m,s,0), value]);
                    }
                }
            }
        }
        rawFile.send(null);
        /*if (x==0)
            alldata = data;
        else
            alldata = new google.visualization.data.join(data, alldata, 'full', [[0,0]], [1], [1]);
        console.log(alldata)
        */
        alldata = data;


        var options = {
          title: Coins[x]+': $'+value.toFixed(2), // most recent value
          width: 900,
          height: 500,
          hAxis: {
            format: 'M/d/yy',
            gridlines: {count: 15}
          },
          vAxis: {
            title: 'Value (USD)',
            gridlines: {count: 10}, //, color: 'none'},
            minValue: 0
          },
          series: {
            0: { color: Colors[x], type: 'line' },
            //1: { color: '#e7711b', type: 'line' },
          },
          backgroundColor: '#bbbbbb',
          interpolateNulls: true,
          //curveType: 'function'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'+x));

        chart.draw(data, options);

      }

    } // end crypto history loop


    // add new row (holding) function
    function addNewRow() {
        //alert('hey');
        /*var table = document.getElementById("holdings_table");
        var tr = document.createElement("tr");
        var td = document.createElement("td");
        var nameblock = document.createTextNode('<input type="text" name="NEWNAME" size="5" />');
        var holdingblock = document.createTextNode('<input type="text" name="NEWHOLDING" />');
        var urlblock = document.createTextNode('<input type="text" name="NEWURL" size="45" />');
        */
        var row = '<tr><td><input type="text" name="NEWNAME" size="5" /></td><td><input type="text" name="NEWHOLDING" /></td><td><input type="text" name="NEWURL" size="45" /></td></tr>';

        /*td.appendChild(nameblock);
        tr.appendChild(td);
        td = document.createElement("td");
        td.appendChild(holdingblock);
        tr.appendChild(td);
        td = document.createElement("td");
        td.appendChild(urlblock);
        tr.appendChild(td);
        */
        // jQuery
        $(row).appendTo("#holdings_table"); //table.append(row); //table.appendChild(tr);

        // adds a new row to table for user input.
    }


    $(document).ready(function() {

        // Make form for editing assets
        var rawFile = new XMLHttpRequest();
        file = "assets.txt";
        rawFile.open("GET", file, false);
        rawFile.onreadystatechange = function ()
        {
            if(rawFile.readyState === 4)
            {
                var display = '<form name="assets" method="POST" action="index.php?save"><table id="holdings_table"><tr><th>Coin</th><th>Amount</th><th>CoinMarketCap URL</th></tr>';
                if(rawFile.status === 200 || rawFile.status == 0)
                {
                    var allText = rawFile.responseText;
                    unique_holdings = allText.split('\n');
                    
                    var thelength = unique_holdings.length;
                    for (i=0; i<thelength; i++) {
                        if (unique_holdings[i] == "") continue;
                        columns = unique_holdings[i].split(/[ ,]+/);
                        display = display + '<tr><td><input type="hidden" value="' + columns[0] + '" name="' + columns[0] + '_name" />' + columns[0] + '</td><td><input type="text" name="' + columns[0] + '_value" value="' + columns[1] + '" /></td><td><input type="text" name="' + columns[0] + '_url" value="' + columns[2] + '" size="45" /></td></tr>';
                    }
                }
            }
            display = display + '</table><input type="submit" value="save assets" /><input type="button" onclick="addNewRow();" value="add new" /></form>';
            document.getElementById("right_form").innerHTML = display;   
        }
        rawFile.send(null);

 


        // READ RUNLOG OUTPUT
        var runlog_chunk_length = 26;
        var rawFile = new XMLHttpRequest();
        file = "runlog";
        rawFile.open("GET", file, false);
        rawFile.onreadystatechange = function ()
        {
            if(rawFile.readyState === 4)
            {
                var display = "";
                if(rawFile.status === 200 || rawFile.status == 0)
                {
                    var allText = rawFile.responseText;
                    chunks = allText.split('\n');
                    
                    var thelength = chunks.length;
                    for (i=thelength-runlog_chunk_length; i<thelength; i++) {
                        if (1)
                            display = display + chunks[i] + '<br />';
                    }
                }
            }
            document.getElementById("runlog_box").innerHTML = display;   
        }
        rawFile.send(null);
        
    });


    </script>

    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>


  <body>
    <h3>Crypto web tracker v0.0 -- Douglas Franz</h3>
    <h4>Based on <a href="https://coinmarketcap.com" target="_blank">Coin Market Cap</a></h4>
    <div id="right_box" style="float:right; position:relative; width: 600px; border: 2px solid black; text-align:left;">
        <div id="right_form">
        edit form goes here
        </div>
        <div id="runlog_box">
        runlog goes here
        </div>
    </div>
    <div id="chart_div0" style="width: 900px; height: 500px;"></div>
    <div id="chart_div1" style="width: 900px; height: 500px;"></div>
    <div id="chart_div2" style="width: 900px; height: 500px;"></div>
    <div id="chart_div3" style="width: 900px; height: 500px;"></div>
    <div id="chart_div4" style="width: 900px; height: 500px;"></div>
    <div id="chart_div5" style="width: 900px; height: 500px;"></div>
    <div id="chart_div6" style="width: 900px; height: 500px;"></div>
    <div id="chart_div7" style="width: 900px; height: 500px;"></div>
    <div id="chart_div8" style="width: 900px; height: 500px;"></div>
    <div id="chart_div9" style="width: 900px; height: 500px;"></div>
    <div id="chart_div10" style="width: 900px; height: 500px;"></div>
    <div id="chart_div11" style="width: 900px; height: 500px;"></div>
    <div id="chart_div12" style="width: 900px; height: 500px;"></div>
  </body>
</html>
