--function 定义

-- Variables
sda = 1-- SDA Pin
scl = 2 -- SCL Pin
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

function print_OLED()
	disp:firstPage()
	repeat
		disp:drawFrame(2,2,126,62)
		--左右距离，高度，内容
		disp:drawStr(5, 5, "")
		disp:drawStr(5, 20, "")
		disp:drawStr(5, 30, "")
		disp:drawStr(5, 50, "")
		
		
		    disp:drawCircle(18, 47, 14)
	until disp:nextPage() == false
	
end


init_OLED(sda,scl)

print_OLED()






