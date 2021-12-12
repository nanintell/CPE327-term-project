<!--
    Form for user to register as a customer.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Custmer Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <style>
        * {
            font-family: 'Waffle Regular';
        }

        .element {
            background-color: #119FA4;
            /* padding: 15px; */
            opacity: 0.85;
            width: 100%;
            color: white;
            font-size: 50px;
            text-align: left;
            margin: 20px 0px;
        }

        .element2 {
            background-color: rgba(17, 159, 164, 0.36);
            /* padding: 15px; */
            width: 100%;
            color: white;
            font-size: 30px;
            text-align: center;
            margin: 20px 0px;
            padding: 10px 500px;
        }

        .form-control {
            font-size: 25px !important;
        }

        .picstyle {
            width: 50px;
            position: absolute;
            left: 100px;
            z-index: 999;
            bottom: 100px;
        }

        .button1 {
            background-color: rgba(255, 255, 255, 0.3);
            background-position: center;
            border: none;
            padding: 0px 0px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 32px;
            font-family: 'Waffle Regular';
            border-radius: 12px;
            color: white;

        }

        .menubar {
            background-color: #225A69;
            /* padding: 15px; */
            opacity: 0.85;
            width: 100%;
            color: white;
            font-size: 30px;
            text-align: right;

        }
    </style>
</head>

<body>
    <!--header-->
    <div class="container-fluid">
        <div class="row">
            <div class="menubar">
                <div class="col">
                    <div class="col-sm-5" style="color:white; font-size:35px; text-align:center;margin-left:800px;">
                        <div class="form-group">
                            <a href='homepage.php' class="button1" style="width:250px">
                                <img src="picture/house.png" alt="" width="30px">
                                <strong> Home</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--seat picture-->
    <div class=picstyle>
        <img src="picture/m07.png" alt="" width=300px;>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="element">
                <img src="picture/pop.png" alt="" width="100px">
                <span style="padding-left: 30px;">Customer Register</span>
            </div>
        </div>
    </div>

    <!--form-->
    <!--require all input to be filled-->
    <div class="container-fluid">
        <div class="row">
            <div class="element2">
                <form action="customerinsert.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <!--name text input-->
                            <label for="Name">Name</label>
                            <input type="text" class="form-control" id="Name" placeholder="Name" name="Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <!--birthday date input-->
                            <label for="Bday">Date of Birth</label>
                            <input type="Date" class="form-control" id="Bday" placeholder="DateofBirth" name="Bday" required>
                        </div>
                        <div class="form-group col-md-6">
                            <!--citizen text input-->
                            <!--require user to enter 13 digit number only-->
                            <label for="CitizenID">Citizen ID</label>
                            <input type="text" class="form-control" id="CitizenID" placeholder="CitizenID" name="CitizenID" pattern="[0-9]{13}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <!--address select input-->
                            <!--only province is stored in the address attribute-->
                            <!--so user only has to select the current province he's living in-->
                            <label for="Address">Address</label>
                            <select name="Address" class="form-control">
                                <option value="Bangkok">Bangkok</option>
                                <option value="Krabi">Krabi </option>
                                <option value="Kanchanaburi">Kanchanaburi </option>
                                <option value="Kalasin">Kalasin </option>
                                <option value="Kamphaeng Phet">Kamphaeng Phet </option>
                                <option value="Khon Kaen">Khon Kaen</option>
                                <option value="Chanthaburi">Chanthaburi</option>
                                <option value="Chachoengsao">Chachoengsao </option>
                                <option value="Chai Nat">Chai Nat </option>
                                <option value="Chaiyaphum">Chaiyaphum </option>
                                <option value="Chumphon">Chumphon </option>
                                <option value="Chonburi">Chonburi </option>
                                <option value="Chiang Mai">Chiang Mai </option>
                                <option value="Chiang Rai">Chiang Rai </option>
                                <option value="Trang">Trang </option>
                                <option value="Trat">Trat </option>
                                <option value="Tak">Tak </option>
                                <option value="Nakhon Nayok">Nakhon Nayok </option>
                                <option value="Nakhon Pathom">Nakhon Pathom </option>
                                <option value="Nakhon Phanom">Nakhon Phanom </option>
                                <option value="Nakhon Ratchasima">Nakhon Ratchasima </option>
                                <option value="Nakhon Si Thammarat">Nakhon Si Thammarat </option>
                                <option value="Nakhon Sawan">Nakhon Sawan </option>
                                <option value="Narathiwat">Narathiwat </option>
                                <option value="Nan">Nan </option>
                                <option value="Nonthaburi">Nonthaburi </option>
                                <option value="Bueng Kan">Bueng Kan</option>
                                <option value="Buriram">Buriram</option>
                                <option value="Prachuap Khiri Khan">Prachuap Khiri Khan </option>
                                <option value="Pathum Thani">Pathum Thani </option>
                                <option value="Prachinburi">Prachinburi </option>
                                <option value="Pattani">Pattani </option>
                                <option value="Phayao">Phayao </option>
                                <option value="Phra Nakhon Si Ayutthaya">Phra Nakhon Si Ayutthaya </option>
                                <option value="Phang Nga">Phang Nga </option>
                                <option value="Phichit">Phichit </option>
                                <option value="Phitsanulok">Phitsanulok </option>
                                <option value="Phetchaburi">Phetchaburi </option>
                                <option value="Phetchabun">Phetchabun </option>
                                <option value="Phrae">Phrae </option>
                                <option value="Phatthalung">Phatthalung </option>
                                <option value="Phuket">Phuket </option>
                                <option value="Maha Sarakham">Maha Sarakham </option>
                                <option value="Mukdahan">Mukdahan </option>
                                <option value="Mae Hong Son">Mae Hong Son </option>
                                <option value="Yasothon">Yasothon </option>
                                <option value="Yala">Yala </option>
                                <option value="Roi Et">Roi Et </option>
                                <option value="Ranong">Ranong </option>
                                <option value="Rayong">Rayong </option>
                                <option value="Ratchaburi">Ratchaburi</option>
                                <option value="Lopburi">Lopburi </option>
                                <option value="Lampang">Lampang </option>
                                <option value="Lamphun">Lamphun </option>
                                <option value="Loei">Loei </option>
                                <option value="Sisaket">Sisaket</option>
                                <option value="Sakon Nakhon">Sakon Nakhon</option>
                                <option value="Songkhla">Songkhla </option>
                                <option value="Samut Sakhon">Samut Sakhon </option>
                                <option value="Samut Prakan">Samut Prakan </option>
                                <option value="Samut Songkhram">Samut Songkhram </option>
                                <option value="Sa Kaeo">Sa Kaeo </option>
                                <option value="Saraburi">Saraburi </option>
                                <option value="Sing Buri">Sing Buri </option>
                                <option value="Sukhothai">Sukhothai </option>
                                <option value="Suphan Buri">Suphan Buri </option>
                                <option value="Surat Thani">Surat Thani </option>
                                <option value="Surin">Surin </option>
                                <option value="Satun">Satun </option>
                                <option value="Nong Khai">Nong Khai </option>
                                <option value="Nong Bua Lamphu">Nong Bua Lamphu </option>
                                <option value="Amnat Charoen">Amnat Charoen </option>
                                <option value="Udon Thani">Udon Thani </option>
                                <option value="Uttaradit">Uttaradit </option>
                                <option value="Uthai Thani">Uthai Thani </option>
                                <option value="Ubon Ratchathani">Ubon Ratchathani</option>
                                <option value="Ang Thong">Ang Thong </option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <!--password input-->
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" placeholder="Password" name="pass" required>
                        </div>
                        <div style="width:100%">
                            <input type="submit" value="submit" style="border-radius: 15px; width: 100px; border: 1px solid black; font-size: 25px;background-color: white;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>

</html>