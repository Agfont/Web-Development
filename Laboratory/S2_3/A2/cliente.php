<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Important: Only recognizes CSS files if they are inside of css/ -->
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<title>Nexthouse</title>
	</head>
<body>
    <nav class="navbar bg-primary justify-content-between text-white">
        <img src="next.png">
        <h3>Welcome to Nexthouse, we hope you find yours!</h3>
        <a class="btn btn-outline-light" type="button" href="sign_up.php">Sign up</a>
    </nav>
	<div class="container-fluid">
        <div class="row destFinder my-3 mx-1 p-3">
            <form action="http://localhost/COW/S2_3/A2/servidor.php" method="POST">
                <div class="form-row align-items-center">
                    <div class="col form-group">
                        <label for="destination">Destination</label>
                        <input type="text" name="destination" id="destination" 
                        placeholder="e.g. Barcelona" size="20" minlength="1" maxlength="20">
                    </div>
                    <div class="col form-group">
                        <label for="checkin">Check-in</label>
                        <input type="date" name="checkin" id="checkin" value="2022-03-28">
                    </div>
                    <div class="col form-group">
                        <label for="checkout">Checkout</label>
                        <input type="date" name="checkout" id="checkout" value="2022-03-30">
                    </div>
                    <div class="col form-group">
                        <label for="guests">Guests</label><br>
                        <input type="number" name="guests" min="1" max="20" id="guests" value="1">
                    </div>
                    <div class="col form-group mt-2">
                        <br>
                        <input type="submit" id="search_button" value="Search">
                    </div>
                </div>
            </form>
        </div>
        <div class="row text-center bg-light">
            <div class="menu col-sm-3 mt-3 mb-3">
                <h3>Countries</h3>
                <div class="list-group">
                    <a href="https://www.google.com/search?q=spain" class="list-group-item">Spain <span
                        class="badge">10</span></a>
                    <a href="https://www.google.com/search?q=brazil" class="list-group-item">Brazil</a>
                    <a href="https://www.google.com/search?q=portugal" class="list-group-item">Portugal</a>
                    <a href="https://www.google.com/search?q=italy" class="list-group-item">Italy</a>
                </div>
            </div>
            <div class="center col-sm-6 mt-3 mb-3">
                <h3>Search hotels at Google here!</h3>
                <form action="http://www.google.com/search" method="GET" id="search-form">
                    <input type="text" name="q"/>
                    <input type="submit" value="Buscar" />
                </form>
            </div>
            <div class="col-sm-3 mt-3 mb-3">
                <h3>Latest deals!</h3>
                <img src="hotel.jpg" class="img-thumbnail">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Price per night</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Barcelona</td>
                        <td>30€</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>São Paulo</td>
                        <td>10€</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Lisboa</td>
                        <td>20€</td>
                        </tr>
                        <tr>
                        <th scope="row">4</th>
                        <td>Roma</td>
                        <td>40€</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row text-center bg-light">
            <img src="banner.jpg" class="img-thumbnail">
        </div>
        <div class="m-1">
            <h6>© 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
