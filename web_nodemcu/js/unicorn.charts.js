/*
 * 作者：黑小马
 * 时间：207/7/20
 */

function zhexiantu(sin,cos) {
	// === Prepare the chart data ===/


	// === Make chart === //
	var plot = $.plot($(".chart"), [{
		data: cos,
		label: "痛经量度",
		color: "#459D1C"

	}, {
		data: sin,
		label: "月经时间",
		color: "#BA1E20"
	}], {
		series: {
			lines: {
				show: true
			},
			points: {
				show: true
			}
		},
		grid: {
			hoverable: true,
			clickable: true
		},
		yaxis: {
			min: 0,
			max: 30
		}
	});

	// === Point hover in chart === //
	var previousPoint = null;
	$(".chart").bind("plothover", function(event, pos, item) {

		if(item) {
			if(previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$('#tooltip').fadeOut(200, function() {
					$(this).remove();
				});
				//0小数位
				var x = item.datapoint[0].toFixed(0),
					y = item.datapoint[1].toFixed(0);

				unicorn.flot_tooltip(item.pageX, item.pageY, item.series.label + "<br>详细数据:<br> " + x + "月-" + y + "日");
			}

		} else {
			$('#tooltip').fadeOut(200, function() {
				$(this).remove();
			});
			previousPoint = null;
		}
	});
}

function shanxintu(datatime) {

	//----------------------------------------排卵量	   
	var data = [];
	var dataname = Array("安全期", "月经期", "排卵期");

	for(var i = 0; i < 3; i++) {
		data[i] = {
			label: dataname[i] + (i + 1),
			data: datatime[i]
		}
	}

	var pie = $.plot($(".pie"), data, {
		series: {
			pie: {
				show: true,
				radius: 3 / 4,
				label: {
					show: true,
					radius: 3 / 4,
					formatter: function(label, series) {
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
					},
					background: {
						opacity: 0.5,
						color: '#000'
					}
				},
				innerRadius: 0.2
			},
			legend: {
				show: false
			}
		}
	});
}
//---------------------------柱状图

function zhuzhuangtu(d1) {

	var data = new Array();
	data.push({
		data: d1,
		bars: {
			show: true,
			barWidth: 0.4,
			order: 1,
		}
	});
	//Display graph
	var bar = $.plot($(".bars"), data, {
		legend: true
	});
	unicorn = {
		// === Tooltip for flot charts === //
		flot_tooltip: function(x, y, contents) {

			$('<div id="tooltip">' + contents + '</div>').css({
				top: y + 5,
				left: x + 5
			}).appendTo("body").fadeIn(200);
		}
	}
}