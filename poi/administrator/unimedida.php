<?php
	session_start();
	require('../settings/connection.php');
	if(isset($_SESSION['poimps'])){
		$conn = new ConexionBD;
		$nivel = substr($_SESSION['poimps'], 5,1);
		$link = $conn->conectarBD();
		$query = "CALL sp_getGerenciaUsuario('G', '0', '".substr($_SESSION['poimps'], 0,5)."')";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$idgerencia = $row[0];
			$gerencia = $row[1];	
		}	
		else{
			mysqli_close($link);
			$link = $conn->conectarBD();
			$query = "CALL sp_getGerenciaUsuario('S', '0', '".substr($_SESSION['poimps'], 0,5)."')";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result);
				$idsubgerencia = $row[0];
				$subgerencia = $row[1];
				mysqli_close($link);
				$link = $conn->conectarBD();
				$query = "CALL sp_getGerenciaUsuario('D', '".substr($idsubgerencia, 0, 2)."' , '".substr($_SESSION['poimps'], 0,5)."')";
				$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result) > 0){
					$row = mysqli_fetch_array($result);
					$idgerencia = $row[0];
					$gerencia = $row[1];	
				}
			}
		}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>.: SISTEMA POI :.</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="">
        <meta content="MUNICIPALIDAD PROVINCIAL DEL SANTA" name="description" />
		<meta content="WILSON VARGAS AGURTO" name="author" />
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
        <link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/select2/select2.css?1424887856" />
        
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="../index.php">
									<span class="text-lg text-bold" style="color: rgb(214, 228, 81);">SISTEMA POI</span>
								</a>
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="headerbar-right">
					<ul class="header-nav header-nav-options">
					</ul><!--end .header-nav-options -->
					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
								<img src="../assets/img/user.png" alt="" />
								<span class="profile-info">
									<?php echo substr($_SESSION['poimps'], 6)?>
								</span>
							</a>
							<ul class="dropdown-menu animation-dock">
								<li><a href="../profile/profile.php">Mi perfil</a></li>
								<li class="divider"></li>
								<li><a href="../login.php?logout"><i class="fa fa-fw fa-power-off text-danger"></i> Salir</a></li>
							</ul><!--end .dropdown-menu -->
						</li><!--end .dropdown -->
					</ul><!--end .header-nav-profile -->
					<!--ul class="header-nav header-nav-toggle">
						<li>
							<a class="btn btn-icon-toggle btn-default" href="#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
								<i class="fa fa-ellipsis-v"></i>
							</a>
						</li>
					</ul><!--end .header-nav-toggle -->
				</div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN OFFCANVAS LEFT -->
			<div class="offcanvas">
			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS LEFT -->

			<!-- BEGIN CONTENT-->
			<div id="content">
				<section>
                	<div class="section-header">
						<ol class="breadcrumb">
							<li><a href="../index.php">Inicio</a></li>
                            <li><a href="#">Administraci&oacute;n</a></li>
                            <li class="active">Unidades de medida</li>
						</ol>
					</div>
                    <div class="section-header">
						<h2 style="color: rgb(169, 43, 46); text-shadow: 1px 1.5px rgb(51, 51, 51);">Unidades de Medida</h2>
					</div>
                    <!--  NUEVA ACTIVIDAD -->
<?php
	if(isset($_GET['new']) && !isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class=" col-md-12">
								<form class="form form-validate floating-label" novalidate method="post" action="crudunimedida.php">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Nueva unidad</header>
										</div>
										<div class="card-body">
                                        	<div class="form-group">
                                                    <input type="text" class="form-control" id="unimedida" name="unimedida" required data-rule-minlength="2">
                                                    <label for="Name1">Nombre de la unidad de medida</label>
                                            </div>
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
												<button type="submit" class="btn btn-raised btn-success ink-reaction col-sm-2 col-sm-offset-8" name="newguardar">Guardar</button>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>


<!--  EDITAR ACTIVIDAD -->
<?php
	}else if(!isset($_GET['new']) && isset($_GET['edit']) && !isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form form-validate floating-label" novalidate method="post" action="crudunimedida.php" onSubmit="return validateForm2()">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Editar unidad de medida</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "SELECT * FROM uni_medida where id_unimedida = ".$_GET['id'];
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
                                                <input type="hidden" name="idu" id="idu" value="<?php echo $_GET['id'];?>">
                                                <input type="hidden" name="unie" id="unie" value="<?php echo $row[1];?>">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="unimedida" name="unimedida"  required data-rule-minlength="2" value="<?php echo $row[1]?>">
                                                    <label for="Name1">Nombre de la unidad de medida</label>
                                                </div>
<?php } ?> 
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href="?"><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2">Cancelar</button></a>
												<button type="submit" class="btn btn-raised btn-success ink-reaction col-sm-2 col-sm-offset-8" name="editar">Guardar cambios</button>
											</div>
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>
<!-- DETALLES DE LA ACTIVIDAD -->
<?php
	}else if(!isset($_GET['newuser']) && !isset($_GET['edit']) && isset($_GET['details'])){
?>
					<div class="section-body ">
                    	<div class="col-lg-offset-1 col-md-10">
								<form class="form floating-label" method="post" action="#">
									<div class="card">
                                    	<div class="card-head style-primary">
											<header>Detalles usuario</header>
										</div>
										<div class="card-body">
<?php
	$link = $conn->conectarBD();
	$query = "CALL sp_getDetailsUser('".$_GET['id']."')";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
?>
                                        	<div class="form-group">
                                            	<input type="text" class="form-control static dirty" id="nameuser" name="nameuser" readonly  value="<?php echo $row[0];?>">
                                                <label for="Name1">Nombre de usuario</label>
                                            </div>
                                        <div class="form-group">
                                            	<input type="text" class="form-control static dirty" id="nameuser" name="nameuser" readonly  value="xxxxxxx">
                                                <label for="Name1">Password</label>
                                            </div>
                                            <div class="form-group">
                                                    <input type="text" class="form-control static dirty" id="nombre" name="nombre" readonly value="<?php echo $row[1];?>">
                                                    <label for="Name1">Nombre completo</label>
                                            </div>
                                            <div class="form-group">
                                                    <input type="email" class="form-control static dirty" id="email" name="email" readonly value="<?php echo $row[2];?>">
                                                    <label for="Name1">E-mail</label>
                                            </div>
<?php
	$sg = $row[3];
	$g = $row[4];
	$estado  = $row[5];
	mysqli_close($link);
	}
	if($sg == ''){
		$link = $conn->conectarBD();
		$query = "CALL sp_getGerenciaUsuario('G', '0', '".$_GET['id']."')";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result);
			$ger = $row[1];
		}
	}
	else{
		$link = $conn->conectarBD();
		$query = "CALL sp_getGerenciaUsuario('S', '0', '".$_GET['id']."')";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result);
			$ids = $row[0];
			$sger = $row[1];
			mysqli_close($link);
			$link = $conn->conectarBD();
			$query = "CALL sp_getGerenciaUsuario('D', '".substr($ids, 0, 2)."', '".$_GET['id']."')";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result);
				$ger = $row[1];
			}
		}
	}
	mysqli_close($link);
?>
                                            <div class="form-group">
                                                    <input type="text" class="form-control static dirty" id="gerencia" name="gerencia" readonly value="<?php echo $ger;?>">
                                                    <label for="Name1">Gerencia</label>
                                            </div>
                                            <div class="form-group">
                                                    <input type="text" class="form-control static dirty" id="subgerencia" name="subgerencia" readonly value="<?php echo $sger;?>">
                                                    <label for="Name1">Subgerencia</label>
                                            </div>
                                            <div class="form-group">
                                                    <input type="text" class="form-control static dirty" id="estado" name="estado" readonly value="<?php if($estado=="A") {echo 'Activo';}else{echo 'Bloqueado';}?>">
                                                    <label for="Name1">Estado</label>
                                            </div>                                           
										</div><!--end .card-body -->
										<div class="card-actionbar style-primary">
											<div class="card-actionbar-row">
                                            	<a href=""><button type="button" class="btn btn-raised btn-default-dark ink-reaction col-sm-2 col-sm-offset-10">Regresar</button></a>
												
											</div>
										</div><!--end .card-actionbar -->

									</div><!--end .card -->
									<em class="text-caption">Debe completar todos los campos</em>
								</form>
							</div>
                    </div>
<!-- LISTAR ACTIVIDADES -->
<?php
	}else {
?>
					<div class="section-body ">
<?php
	if(isset($_GET['exi'])){
?>
                        <div class="row">
                        	<div class="col-sm-12">	
                            	<div class="alert alert-success" role="alert">
                                	
                                	<strong>Exito!</strong> la operaci&oacute;n se ejecuto con exito y  correctamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}else if(isset($_GET['err'])){
?>
					 	<div class="row">
                        	<div class="col-sm-12">	
                            	<div class="alert alert-danger" role="alert">
                                	<strong>Oh no puede ser!</strong> ocurrio un error.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            </div>
                        </div>
<?php
	}
?>
                        <div class="row">
							<div class="col-md-12 ">
								<h4></h4>
							</div><!--end .col -->
							<div class="col-lg-12 ">
                            	<div class="card card-underline">
                                	<div class="card-head">
                                    	<header></header>
                                        <div class="tools" style="width:300px;">
                                            <a class="btn" href="?new">
                                            	<i class="md md-add-circle"></i>&nbsp;Nueva unidad de medida
                                            </a>
                                    
                                        </div>                                    
                                    </div>
                                	<div class="card-body">
								<div class="table-responsive">
									<table id="datatable1" class="table table-striped table-hover">
										<thead>
											<tr>
												<th>Unidad de medida</th>
                                                <th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
<?php
	$link = $conn->conectarBD();
		$query = "CALL sp_getUniMedida()";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)){
?>
											<tr>
												<td><?php echo $row[1]?></td>
                                                <td class="text-center"> 
                                                <a href="?edit&id=<?php echo $row[0];?>"><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Editar unidad de medida"><i class="fa fa-pencil"></i></button></a>   
										<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar unidad de medida" onClick="eliminarRegistro('<?php echo $row[0];?>')"><i class="md md-delete"></i></button>
												</td>
											</tr>				
<?php
			}
		}
	mysqli_close($link);
?>
											
										</tbody>
									</table>
								</div><!--end .table-responsive -->
                                </div></div>
							</div><!--end .col -->
						</div>
						<!--end .row -->
					</div><!--end .section-body -->
				
<?php
	}
?>
                    
					<!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

			<!-- BEGIN MENUBAR-->
			<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="index.php">
							<span class="text-lg text-bold text-primary ">SISTEMA&nbsp;POI</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">

						<!-- BEGIN DASHBOARD -->
						<li>
							<a href="../index.php">
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Inicio</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->

						<!-- BEGIN EMAIL -->
						<li>
							<a href="../assets/docs/estructura_organica.pdf" target="_blank">
								<div class="gui-icon"><i class="fa fa-sitemap"></i></div>
								<span class="title">Estructura organica</span>
							</a>
						</li><!--end /menu-li -->
                        <li>
							<a href="../assets/docs/objetivos_poi_2016.pdf" target="_blank">
								<div class="gui-icon"><i class="md md-share"></i></div>
								<span class="title">Objetivos POI</span>
							</a>
						</li>
                        <li>
							<a href="../assets/docs/unidad_medida_metas_operativas.pdf" target="_blank" >
								<div class="gui-icon"><i class="fa fa-heartbeat"></i></div>
								<span class="title">Unidades Medida</span>
							</a>
						</li>
<?php
if($nivel != "A") {
?>
                        <li>
							<a href="../programming/activities.php">
								<div class="gui-icon"><i class="fa fa-list-ol"></i></div>
								<span class="title">Programaci&oacute;n de Actividades</span>
							</a>
						</li>
<?php
	}
?>
                        
						<!-- BEGIN UI -->
<?php
	if($nivel == "A") {
?>
						<li class="gui-folder">
							<a class="active">
								<div class="gui-icon"><i class="fa fa-gears"></i></div>
								<span class="title">Administraci&oacute;n</span>
							</a>
							<!--start submenu -->
							<ul>
								<li><a href="users.php"><span class="title">Usuarios</span></a></li>
								<li><a href="ranking.php"><span class="title">Ranking</span></a></li>
                                <li><a href="" class="active"><span class="title">Unidades de Medida</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
<?php
	}
?>

					</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; <?php if(date('Y') == "2015"){echo date('Y'); } else { echo "2015 - ".date('Y'); } ?></span> <strong>MPS</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->

			<!-- BEGIN OFFCANVAS RIGHT -->
			<!--end .offcanvas-->
			<!-- END OFFCANVAS RIGHT -->

		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../assets/js/libs/spin.js/spin.min.js"></script>
		<script src="../assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../assets/js/libs/moment/moment.min.js"></script>
		<script src="../assets/js/libs/flot/curvedLines.js"></script>
		<script src="../assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
		<script src="../assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
		<script src="../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="../assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="../assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
		<script src="../assets/js/libs/d3/d3.min.js"></script>
		<script src="../assets/js/libs/d3/d3.v3.js"></script>
		<script src="../assets/js/libs/rickshaw/rickshaw.min.js"></script>
		<script src="../assets/js/core/source/App.js"></script>
		<script src="../assets/js/core/source/AppNavigation.js"></script>
		<script src="../assets/js/core/source/AppOffcanvas.js"></script>
		<script src="../assets/js/core/source/AppCard.js"></script>
		<script src="../assets/js/core/source/AppForm.js"></script>
		<script src="../assets/js/core/source/AppNavSearch.js"></script>
		<script src="../assets/js/core/source/AppVendor.js"></script>
		<script src="../assets/js/core/demo/Demo.js"></script>
        <script src="../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
		<script src="../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
		<script src="../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../assets/js/libs/select2/select2.min.js"></script>
        <script src="../assets/js/core/demo/DemoTableDynamic.js"></script>
        <script src="../assets/js/core/demo/DemoFormComponents.js"></script>
        <script>
			function eliminarRegistro(ida){
				confirmar = confirm("¿En serio desea eliminar el registro, una vez hecho ello no hay forma de recuperarlo.?")
				if(confirmar){
					window.location.href="crudunimedida.php?delete=N&id="+ida;
				}
			}
			function validateForm2(){
				var ne = $('#unie').val();
				var nee = $('#unimedida').val();
				if(ne == nee){
					alert('No se detectaron cambios');
					return false;
				}
				else{
					return true;
				}
				return false;
			}
		</script>
		<!-- END JAVASCRIPT -->
<div id="flotante2">
                    	<span>
                                	Municipalidad Provincial del Santa
                                </span>
                    </div>
                    <div id="flotante">
                            	<span>
                                	Gerencia de Planeamiento y Presupuesto
                                </span>
                    </div>
                    <div id="flotante3">
                    	<img src="../assets/img/logo_30_30.png"/>&nbsp;<img src="../assets/img/pescadito.png"/>
                    </div>
	</body>
</html>




<?php
	}
	else{
		header("Location: ../login.php");
	}
?>