<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
    <?php 
    function curl(){ 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:8080/api",
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: random123678abcghi",
            ),
        ));
            
        $output = curl_exec($curl); 	
        curl_close($curl);      
        
        $data = json_decode($output);   
        
        return $data;
    } 
    
    ?>
    <div class="p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
        <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div> 
    <hr>
    <!-- tampilkan data disini -->
    <div class="table-responsive card m-5 p-5">
        <table class="table text-center">
            <thead>
                <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Username</th>
                <th style="width: 30%;">Alamat</th>
                <th style="width: 10%;">Total Harga</th>
                <th style="width: 10%;">Ongkir</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 25%;">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $send1 = curl();

                    if(!empty($send1)){
                        $hasil1 = $send1->results;
                        $i = 1; 

                        if(!empty($hasil1)){
                            foreach($hasil1 as $item1){ 
                                ?>
                                <tr>
                                    <td scope="row" class="text-start"><?= $i++ ?></td>
                                    <td>
                                        <?= $item1->username; ?>
                                    </td>
                                    <td>
                                        <?= $item1->alamat; ?>
                                    </td>
                                    <td>
                                        <?= $item1->total_harga; ?>
                                    </td>
                                    <td>
                                        <?= $item1->ongkir; ?>
                                    </td>
                                    <td>
                                        <?= $item1->status; ?>
                                    </td>
                                    <td>
                                        <?= $item1->created_at; ?>
                                    </td>
                                </tr> 
                                <?php
                            } 
                        }
                    }
                    ?> 
            </tbody>
        </table>
    </div> 

    <script>
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById("jam").innerHTML = waktu.getHours();
            document.getElementById("menit").innerHTML = waktu.getMinutes();
            document.getElementById("detik").innerHTML = waktu.getSeconds();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>