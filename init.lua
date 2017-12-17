--function 定义
--oled
sda = 1
scl = 2
--hdt
pin = 5
wendu=""
shidu=""
weather=""

--------Oled屏幕初始化
function init_OLED(sda,scl) --Set up the u8glib lib
	sla = 0x3C
	i2c.setup(0, sda, scl, i2c.SLOW)
	disp = u8g.ssd1306_128x64_i2c(sla)
	disp:setFont(u8g.font_6x10)
	disp:setFontRefHeightExtendedText()
	disp:setDefaultForegroundColor()
	disp:setFontPosTop()
	--disp:setRot180()           -- Rotate Display if needed
end

--------温度湿度检查函数
function hdt()
	
	status, temp, humi, temp_dec, humi_dec = dht.read(pin)
	if status == dht.OK then
		
		-- Float firmware using this example
		print("DHT Temperature:"..temp..";".."Humidity:"..humi)
		wendu=temp
		shidu=humi
	elseif status == dht.ERROR_CHECKSUM then
		print( "DHT Checksum error." )
	elseif status == dht.ERROR_TIMEOUT then
		print( "DHT timed out." )
	end
	
end

--------热释人体感应函数
function check()
	gpio.mode(6, gpio.INPUT)
	
	timer = tmr.create()
	runTime = tmr.time()
	tmr.register(timer, 1000*1, tmr.ALARM_AUTO, function ()
		if gpio.read(6)==1 then
			--开启提交
			print("有人")
			url_web="http://lovehxm.top/yzw/app_api.php?insert=wifi&wendu="..wendu.."&shidu="..shidu.."&weather="..weather
			print(url_web)
			http.get(url_web, nil, function (code, data)
				if (code < 0) then
					print("HTTP request failed")
				else
					print(code, data)
				end
			end)
		end
	end)
	tmr.start(timer)
end

---------打印屏幕函数
function print_OLED()
	disp:firstPage()
	repeat
		disp:drawFrame(2,2,126,62)
		--左右距离，高度，内容
		disp:drawStr(5, 5, str1)
		disp:drawStr(5, 20, str2)
		disp:drawStr(5, 30, str3)
		disp:drawStr(5, 50, str5)
		
		
		--    disp:drawCircle(18, 47, 14)
	until disp:nextPage() == false
	
end

---------TCP连接初始
function init_connect(payload)
	local t = sjson.decode(payload)
	if t.ssid~=nil and t.pass~=nil then
		print(t.ssid)
		print(t.pass)
		--wifi.setmode(wifi.STATION)
		--输出城市
		write_city(t.city)
		station_cfg={}
		station_cfg.ssid=t.ssid
		station_cfg.pwd=t.pass
		wifi.sta.config(station_cfg)
		--wifi.sta.connect()
		--wifi.sta.config(t.ssid,t.pass)
		wifi.sta.autoconnect(1)
		tmr.alarm(0, 10000, tmr.ALARM_SINGLE, dingqi)
		
		
	end
end

---------App连接服务器配置
function tcp_socket()
	--智能模式配置wifi
	srv=net.createServer(net.TCP)
	srv:listen(80, function (conn)
		conn:on("receive", function (conn,payload)
			print(payload)
			init_connect(payload)
			conn:send("配置完毕")
			
		end)
	end)
end

---------定时器回调，用于配置后显示
function dingqi()
	
	if wifi.sta.getip() then
		str3="AP_IP:"..wifi.sta.getip()
	else
		str3="AP_IP:0.0.0.0"
	end
	print_OLED()
	http_client()
end

----------定时器回调。用于加载前缓冲
function start_load()
	str1=" hxm welcome weather"
	str2="IP:"..wifi.ap.getip()
	
	if wifi.sta.getip() then
		str3="AP_IP:"..wifi.sta.getip()
	else
		str3="AP_IP:network_error"
	end
	print_OLED()
	
	tmr.alarm(0, 10000, tmr.ALARM_SINGLE,tq_server)
end

----------启动天气函数，同时启动循环天气，这里可以改写一个函数，看自己习惯
function tq_server()
	
	--开启人体检测：
	check()
	--异常处理这个网络请求 错误status为false
	status = xpcall( http_client, myerrorhandler )
	--开启后面的循环
	if status then
		rexun()
	end
end

---------异常处理函数
function myerrorhandler( err )
	--print( "ERROR:", err )
	start_load()
	--停止这个循环
	--tmr.stop(timer)
end

---------网络天气获取
function http_client()
	
	str5=""
	url="http://www.sojson.com/open/api/weather/json.shtml?city="..read_city()
	print(url)
	http.get(url, nil, function (code, data)
		if (code < 0) then
			print("HTTP request failed")
		else
			print(code,data)
			--json解析为tables
			local t = sjson.decode(data)
			--二级解析
			local value = t["data"]
			
			print(value.wendu.."°C")
			print(value.shidu)
			--三级解析
			local forecast = value["forecast"]
			--无key值时用索引
			print(forecast[1].type)
			st_type=""
			if forecast[1].type=="小雨" then
				st_type="xy"
			elseif forecast[1].type=="阴" then
				st_type="y"
			elseif forecast[1].type=="晴" then
				st_type="q"
			elseif forecast[1].type=="阵雨" then
				st_type="zy"
			elseif forecast[1].type=="多云" then
				st_type="dy"
			elseif forecast[1].type=="中雨" then
				st_type="zoy"
			else
				st_type="xxxx"
			end
			
			--网络天气温度：value.wendu，湿度：value.shidu
			weather=st_type
			hdt()
			str5="    "..wendu.."C  "..shidu.."%  "..st_type
			print(str5)
			print_OLED()
			
		end
	end)
end

---------获取APP的天气地区处理函数
function write_city(city)
	--判断是否存在，存在就删除
	if file.exists("city.config") then
		file.remove("city.config")
	end
	if file.open("city.config", "a") then
		-- write 'foo bar' to the end of the file
		file.write(city)
		file.close()
	end
end

---------读取天气函数
function read_city()
	re_city=""
	if file.open("city.config", "r") then
		re_city= file.read()
		file.close()
	end
	return re_city
end

---------定时循环获取天气
function rexun()
	timer = tmr.create()
	runTime = tmr.time()
	tmr.register(timer, 1000*20, tmr.ALARM_AUTO, function ()
		
		print("count&runTime=")
		http_client()
		
	end)
	tmr.start(timer)
end
-- Main Program

--设置模式
wifi.setmode(wifi.STATIONAP)
init_OLED(sda,scl)
str1="     Loading..."
str2=""
str3=""
str5=""
print_OLED()
tmr.alarm(0, 7000, tmr.ALARM_SINGLE, start_load)
tcp_socket()









