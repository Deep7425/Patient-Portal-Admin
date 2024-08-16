
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="modal-content">
                    <div class="modal-body pb-1">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>-->
                        <div class="text-center">
                            <h3 class="mt-3">Welcome To {{$orgData->title}}<span class="text-primary"> Health Assessment</span></h3>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-interval="50000">
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-center text-center-welcome">
                                        <img src="/quiz-asset/img/pages/welcome.png" class="img-fluid my-4" alt="images">
                                    </div>
                                    <div class="col-md-6">
                                        <p class="f-16"><strong>Health Assessment </strong> will come with student score list.</p>
                                        <p class="f-16"> it include <strong>5 Personality Trait Domain Scoring</strong> like</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Negative Affect</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Detachment</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Antagonism</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Disinhibition</p>
                                        <p class="mb-2 f-16"><i class="feather icon-check-circle mr-2 text-primary"></i>Psychoticism</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" data-interval="50000">
                            	<div class="row">
                            	<div class="col-lg-6">
                                <img src="../quiz-asset/img/admin-1.png" class="img-fluid mt-0" alt="images">
								</div>
								
								<div class="col-lg-6">
								 <div class="card mb-4">
									<h6 class="card-header">Login</h6>
									<div class="card-body">
									<div class="alert alert-dark-primary alert-dismissible show" id="redAlert" style="display:none;">
										Incorrect Password — check it out!
									</div>
									
									<div class="alert alert-dark-success alert-dismissible show" id="greenAlert" style="display:none;">
										Login Successfully !
									</div>
											<div class="form-row">
												<div class="form-group col-md-12 form-group-topnew">
													<label class="form-label">User</label>
													<input type="text" class="form-control" placeholder="User" value="{{$orgData->title}}" readonly>
													<div class="clearfix"></div>
												</div>
												<div class="form-group col-md-12">
													<label class="form-label">Password</label>
													<input type="password" class="form-control" id="cPwd" placeholder="Password">
													<div class="clearfix"></div>
												</div>
											</div>
											<!--<div class="form-group">
												<label class="custom-control custom-checkbox m-0">
													<input type="checkbox" class="custom-control-input">
													<span class="custom-control-label">Remember me</span>
												</label>
											</div>-->
											<button type="button" class="btn btn-primary signInBtn">Sign in</button>
									</div>
								</div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" style="transform:rotate(180deg);margin-bottom:-1px">
                        <path class="elementor-shape-fill" fill="#2c3134" opacity="0.33"
                            d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z">
                        </path>
                        <path class="elementor-shape-fill" fill="#2c3134" opacity="0.66"
                            d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                        <path class="elementor-shape-fill" fill="#2c3134" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z">
                        </path>
                    </svg>
                    <div class="modal-body text-center py-4" style="background:#2c3134">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
                        </ol>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="ml-2">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="mr-2">Next</span>
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core scripts -->
    <script src="/patient_portal_live/quiz-asset/js/pace.js"></script>
    <script src="/patient_portal_live/quiz-asset/js/jquery-3.2.1.min.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/popper/popper.js"></script>
    <script src="/patient_portal_live/quiz-asset/js/bootstrap.js"></script>
    <!-- <script src="/patient_portal_live/patient_portal_live/quiz-asset/js/sidenav.js"></script> -->
    <script src="/patient_portal_live/quiz-asset/js/layout-helpers.js"></script>
    <script src="/patient_portal_live/quiz-asset/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="/patient_portal_live/quiz-asset/libs/eve/eve.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/flot/flot.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/flot/curvedLines.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/chart-am4/core.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/chart-am4/charts.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/chart-am4/animated.js"></script>
	
	<script src="/patient_portal_live/quiz-asset/libs/tableexport/tableexport.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/moment/moment.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/bootstrap-table/bootstrap-table.js"></script>
    <script src="/patient_portal_live/quiz-asset/libs/bootstrap-table/extensions/export/export.js"></script>

    <!-- Demo -->
    <script src="/patient_portal_live/quiz-asset/js/demo.js"></script>
	<script src="/patient_portal_live/quiz-asset/js/analytics.js"></script>
    <script src="/patient_portal_live/quiz-asset/js/pages/tables_bootstrap-table.js"></script>
    <script>
        $(document).ready(function() {
            checkCookie();
			// $('#example').dataTable({"responsive": true});
        });

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            var ticks = getCookie("modelopen");
			console.log(ticks);
            if (ticks == "") {
                // ticks++;
                // setCookie("modelopen", ticks, 1);
                // if (ticks == "2" || ticks == "1" || ticks == "0") {
                    // $('#exampleModalCenter').modal();
                // }
            // } else {
                // $('#exampleModalCenter').modal();
				$("#exampleModalCenter").modal({
					show:true,
					backdrop:'static',
					 keyboard: false
				});
		    }
        }
		jQuery(document).on("click", ".logOut", function (e) {
			document.cookie = 'modelopen=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			location.href = '';
		});
		jQuery(document).on("click", ".signInBtn", function (e) {
			let cPwd = $("#cPwd").val();
			let upwd =  atob($("#cuP21").attr('text-data'));
			if(cPwd  == upwd){
				$("#redAlert").hide();
				$("#greenAlert").show();
				setCookie("modelopen", 1,2);
				setTimeout(function(){
					$('#exampleModalCenter').modal('hide');
				}, 1000);
			}
			else{
				$("#redAlert").show();
				$("#greenAlert").hide();
			}
		});
// [ XY-Draggable-1 chart ] start
let chartArray = JSON.parse($("#chartArray").val());
let totChartVal = $("#totChartVal").val();
$(function() {
	console.log(totChartVal);
	am4core.useTheme(am4themes_animated);
	var chart = am4core.create("am-xy-10", am4charts.XYChart);
	chart.data = chartArray;
	console.log(chart.data);
	chart.padding(40, 40, 0, 0);
	chart.maskBullets = false;
	
	var text = chart.plotContainer.createChild(am4core.Label);
	// text.text = "Drag column bullet to change its value";
	text.y = 92;
	text.x = am4core.percent(98);
	text.horizontalCenter = "right";
	text.zIndex = 100;
	text.fillOpacity = 1;

	var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "title";
	categoryAxis.renderer.grid.template.disabled = true;
	categoryAxis.renderer.minGridDistance = 50;

	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

	valueAxis.strictMinMax = true;
	valueAxis.min = 0;
	valueAxis.max = totChartVal;
	valueAxis.renderer.minWidth = 60;

	var series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.categoryX = "title";
	series.dataFields.valueY = "tot";
	series.tooltip.pointerOrientation = "vertical";
	series.tooltip.dy = -8;
	series.sequencedInterpolation = true;
	series.defaultState.interpolationDuration = 1500;
	series.columns.template.strokeOpacity = 0;

	var labelBullet = new am4charts.LabelBullet();
	series.bullets.push(labelBullet);
	labelBullet.label.text = "{valueY.value.formatNumber('#.')}";
	labelBullet.strokeOpacity = 0;
	labelBullet.stroke = am4core.color("#dadada");
	labelBullet.dy = -20;

	// var bullet = series.bullets.create();
	// bullet.stroke = am4core.color("#ffffff");
	// bullet.strokeWidth = 3;
	// bullet.opacity = 0;
	// bullet.defaultState.properties.opacity = 0;

	// bullet.cursorOverStyle = am4core.MouseCursorStyle.verticalResize;
	// bullet.draggable = false;

	// var hoverState = bullet.states.create("hover");
	// hoverState.properties.opacity = 1;

	// var circle = bullet.createChild(am4core.Circle);
	// circle.radius = 8;

	// bullet.events.on("drag", event => {
		// handleDrag(event);
	// });

	// bullet.events.on("dragstop", event => {
		// handleDrag(event);
		// var dataItem = event.target.dataItem;
		// dataItem.column.isHover = false;
		// event.target.isHover = false;
	// });
	function handleDrag(event) {
		var dataItem = event.target.dataItem;
		var value = valueAxis.yToValue(event.target.pixelY);
		dataItem.valueY = value;
		dataItem.column.isHover = true;
		dataItem.column.hideTooltip(0);
		event.target.isHover = true;
	}
	var columnTemplate = series.columns.template;
	columnTemplate.column.cornerRadiusTopLeft = 8;
	columnTemplate.column.cornerRadiusTopRight = 8;
	columnTemplate.fillOpacity = 1;
	// columnTemplate.tooltipText = "drag me";
	columnTemplate.tooltipY = 0;

	var columnHoverState = columnTemplate.column.states.create("hover");
	columnHoverState.properties.fillOpacity = 1;

	columnHoverState.properties.cornerRadiusTopLeft = 35;
	columnHoverState.properties.cornerRadiusTopRight = 35;

	// columnTemplate.events.on("over", event => {
		// var dataItem = event.target.dataItem;
		// var itemBullet = dataItem.bullets.getKey(bullet.uid);
		// itemBullet.isHover = true;
	// });
	// columnTemplate.events.on("out", event => {
		// var dataItem = event.target.dataItem;
		// var itemBullet = dataItem.bullets.getKey(bullet.uid);

		// setTimeout(() => {
			// itemBullet.isHover = false;
		// }, 1000);
	// });
	// columnTemplate.events.on("down", event => {
		// var dataItem = event.target.dataItem;
		// var itemBullet = dataItem.bullets.getKey(bullet.uid);
		// itemBullet.dragStart(event.pointer);
	// });
	// columnTemplate.events.on("positionchanged", event => {
		// var dataItem = event.target.dataItem;
		// var itemBullet = dataItem.bullets.getKey(bullet.uid);

		// var column = dataItem.column;
		// itemBullet.minX = column.pixelX + column.pixelWidth / 2;
		// itemBullet.maxX = itemBullet.minX;
		// itemBullet.minY = 0;
		// itemBullet.maxY = chart.seriesContainer.pixelHeight;
	// });
	series.columns.template.adapter.add("fill", (fill, target) => {
		return chart.colors.getIndex(target.dataItem.index);
	});
});
// [ XY-Draggable-1 chart ] end

let wildChart = JSON.parse($("#wildChart").val());
let wildtotChartVal = $("#wildtotChartVal").val();
$(function() {
	console.log(totChartVal);
	am4core.useTheme(am4themes_animated);
	var chart = am4core.create("am-xy-20", am4charts.XYChart);
	chart.data = wildChart;
	console.log(chart.data);
	chart.padding(40, 40, 0, 0);
	chart.maskBullets = false;
	
	var text = chart.plotContainer.createChild(am4core.Label);
	// text.text = "Drag column bullet to change its value";
	text.y = 92;
	text.x = am4core.percent(98);
	text.horizontalCenter = "right";
	text.zIndex = 100;
	text.fillOpacity = 1;

	var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "title";
	categoryAxis.renderer.grid.template.disabled = true;
	categoryAxis.renderer.minGridDistance = 50;

	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

	valueAxis.strictMinMax = true;
	valueAxis.min = 0;
	valueAxis.max = wildtotChartVal;
	valueAxis.renderer.minWidth = 60;

	var series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.categoryX = "title";
	series.dataFields.valueY = "tot";
	series.tooltip.pointerOrientation = "vertical";
	series.tooltip.dy = -8;
	series.sequencedInterpolation = true;
	series.defaultState.interpolationDuration = 1500;
	series.columns.template.strokeOpacity = 0;

	var labelBullet = new am4charts.LabelBullet();
	series.bullets.push(labelBullet);
	labelBullet.label.text = "{valueY.value.formatNumber('#.')}";
	labelBullet.strokeOpacity = 0;
	labelBullet.stroke = am4core.color("#dadada");
	labelBullet.dy = -20;

	function handleDrag(event) {
		var dataItem = event.target.dataItem;
		var value = valueAxis.yToValue(event.target.pixelY);
		dataItem.valueY = value;
		dataItem.column.isHover = true;
		dataItem.column.hideTooltip(0);
		event.target.isHover = true;
	}
	var columnTemplate = series.columns.template;
	columnTemplate.column.cornerRadiusTopLeft = 8;
	columnTemplate.column.cornerRadiusTopRight = 8;
	columnTemplate.fillOpacity = 1;
	// columnTemplate.tooltipText = "drag me";
	columnTemplate.tooltipY = 0;

	var columnHoverState = columnTemplate.column.states.create("hover");
	columnHoverState.properties.fillOpacity = 1;

	columnHoverState.properties.cornerRadiusTopLeft = 35;
	columnHoverState.properties.cornerRadiusTopRight = 35;
	series.columns.template.adapter.add("fill", (fill, target) => {
		return chart.colors.getIndex(target.dataItem.index);
	});
});
// [ XY-Draggable-1 chart ] end
let piChartArray = JSON.parse($("#piChartArray").val());
$(function() {
	var chart = am4core.create("am-pie-1", am4charts.PieChart);
	am4core.useTheme(am4themes_animated);
	chart.data = piChartArray;
	var pieSeries = chart.series.push(new am4charts.PieSeries());
	pieSeries.dataFields.value = "tot";
	pieSeries.dataFields.category = "title";
	chart.legend = new am4charts.Legend();
	pieSeries.labels.template.disabled = false;
	pieSeries.ticks.template.disabled = false;
	pieSeries.colors.step = 1;
	
		
	pieSeries.colors.list = [
		new am4core.color('#3c924a'),
		new am4core.color('#eb8c25'),
		new am4core.color('#b3170f'),
	]
});


let piChartRegArray = JSON.parse($("#piChartRegArray").val());
$(function() {
	var chart = am4core.create("am-pie-2", am4charts.PieChart);
	am4core.useTheme(am4themes_animated);
	chart.data = piChartRegArray;
	var pieSeries = chart.series.push(new am4charts.PieSeries());
	pieSeries.dataFields.value = "tot";
	pieSeries.dataFields.category = "title";
	chart.legend = new am4charts.Legend();
	pieSeries.labels.template.disabled = false;
	pieSeries.ticks.template.disabled = false;
	pieSeries.colors.step = 3;
});
</script>
