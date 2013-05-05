/* 
 * More info at: http://phpjs.org
 * 
 * This is version: 2.61
 * php.js is copyright 2009 Kevin van Zonneveld.
 * 
 * Portions copyright Brett Zamir (http://brettz9.blogspot.com), Kevin van
 * Zonneveld (http://kevin.vanzonneveld.net), Onno Marsman, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Ricardo F. Santos, Jack,
 * Jonas Raoni Soares Silva (http://www.jsfromhell.com), Philip Peterson, Ates
 * Goral (http://magnetiq.com), Legaev Andrey, Martijn Wieringa, Nate, Enrique
 * Gonzalez, Philippe Baumann, Webtoolkit.info (http://www.webtoolkit.info/),
 * Theriault, Ash Searle (http://hexmen.com/blog/), Carlos R. L. Rodrigues
 * (http://www.jsfromhell.com), travc, Ole Vrijenhoek, Jani Hartikainen,
 * Johnny Mast (http://www.phpvrouwen.nl), d3x, Erkekjetter, stag019, Michael
 * Grier, GeekFG (http://geekfg.blogspot.com), Andrea Giammarchi
 * (http://webreflection.blogspot.com), marrtins, Alex, Steven Levithan
 * (http://blog.stevenlevithan.com), Mirek Slugen, Marc Palau, Breaking Par
 * Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * David, mdsjack (http://www.mdsjack.bo.it), KELAN, Public Domain
 * (http://www.json.org/json2.js), gettimeofday, Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Arpad Ray (mailto:arpad@php.net), gorthaur, Thunder.m, Aman Gupta,
 * Pellentesque Malesuada, Sakimori, Alfonso Jimenez
 * (http://www.alfonsojimenez.com), Karol Kowalski, AJ, Lars Fischer, Caio
 * Ariede (http://caioariede.com), Tyler Akins (http://rumkin.com), Steve
 * Hilder, Oleg Eremeev, Douglas Crockford (http://javascript.crockford.com),
 * Steve Clay, David James, Subhasis Deb, T. Wild, Ole Vrijenhoek
 * (http://www.nervous.nl/), Hyam Singer (http://www.impact-computing.com/),
 * Lincoln Ramsay, kenneth, djmix, class_exists, mktime, sankai, Linuxworld,
 * Pyerre, Jon Hohle, madipta, Sanjoy Roy, noname, Felix Geisendoerfer
 * (http://www.debuggable.com/felix), 0m3r, Marco, Paul, J A R, Bayron
 * Guevara, john (http://www.jd-tech.net), Ozh, David Randall, Bryan Elliott,
 * MeEtc (http://yass.meetcweb.com), Brad Touesnard, Tim Wiel, Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), XoraX (http://www.xorax.info),
 * T0bsn, Thiago Mata (http://thiagomata.blog.com), Soren Hansen, duncan,
 * Gilbert, Marc Jansen, Francesco, echo is bad, Der Simon
 * (http://innerdom.sourceforge.net/), Eugene Bulkin (http://doubleaw.com/),
 * LH, Slawomir Kaniecki, ger, Eric Nagel, Bobby Drake, Pul, rezna, Mick@el,
 * Pierre-Luc Paour, Martin Pool, Kirk Strobeck, Luke Godfrey, Blues
 * (http://tech.bluesmoon.info/), setcookie, YUI Library:
 * http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html, Blues at
 * http://hacks.bluesmoon.info/strftime/strftime.js, Christian Doebler,
 * penutbutterjelly, Anton Ongson, Simon Willison (http://simonwillison.net),
 * Gabriel Paderni, Kristof Coomans (SCK-CEN Belgian Nucleair Research
 * Centre), Saulo Vallory, hitwork, Norman "zEh" Fuchs, dptr1988, sowberry,
 * Yves Sucaet, Nick Callen, ejsanders, johnrembo, Pedro Tainha
 * (http://www.pedrotainha.com), DxGx, Wagner B. Soares, Valentina De Rosa,
 * Daniel Esteban, uestla, T.Wild, Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), ChaosNo1, metjay,
 * strcasecmp, strcmp, Andreas, Garagoth, Cord, Victor, stensi, Manish, Matt
 * Bradley, Tim de Koning, taith, Robin, Jalal Berrami, date, Nathan, nobbler,
 * marc andreu, Arno, Mateusz "loonquawl" Zalega, Francois, Scott Cariss,
 * ReverseSyntax, FremyCompany, Tod Gentille, booeyOH, Cagri Ekin, Luke Smith
 * (http://lucassmith.name), Ben Bryan, Leslie Hoare, Andrej Pavlovic, Dino,
 * mk.keck, Rival, Diogo Resende, gabriel paderni, FGFEmperor, baris ozdil,
 * Yannoo, jakes, Howard Yeend, Allan Jensen (http://www.winternet.no),
 * Benjamin Lupton, Atli Þór
 * 
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */ 


function base64_decode( data ) {
    // Decodes string using MIME base64 algorithm  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/base64_decode
    // +   original by: Tyler Akins (http://rumkin.com)
    // +   improved by: Thunder.m
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Pellentesque Malesuada
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: utf8_decode
    // *     example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
    // *     returns 1: 'Kevin van Zonneveld'
    // mozilla has this native
    // - but breaks in 2.0.0.12!
    //if (typeof this.window['btoa'] == 'function') {
    //    return btoa(data);
    //}

    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, ac = 0, dec = "", tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1<<18 | h2<<12 | h3<<6 | h4;

        o1 = bits>>16 & 0xff;
        o2 = bits>>8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');
    dec = this.utf8_decode(dec);

    return dec;
}

function base64_encode( data ) {
    // Encodes string using MIME base64 algorithm  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/base64_encode
    // +   original by: Tyler Akins (http://rumkin.com)
    // +   improved by: Bayron Guevara
    // +   improved by: Thunder.m
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Pellentesque Malesuada
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: utf8_encode
    // *     example 1: base64_encode('Kevin van Zonneveld');
    // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    // mozilla has this native
    // - but breaks in 2.0.0.12!
    //if (typeof this.window['atob'] == 'function') {
    //    return atob(data);
    //}
        
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, ac = 0, enc="", tmp_arr = [];

    if (!data) {
        return data;
    }

    data = this.utf8_encode(data+'');
    
    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);

        bits = o1<<16 | o2<<8 | o3;

        h1 = bits>>18 & 0x3f;
        h2 = bits>>12 & 0x3f;
        h3 = bits>>6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);
    
    enc = tmp_arr.join('');
    
    switch( data.length % 3 ){
        case 1:
            enc = enc.slice(0, -2) + '==';
        break;
        case 2:
            enc = enc.slice(0, -1) + '=';
        break;
    }

    return enc;
}

function checkdate( month, day, year ) {
    // Returns true(1) if it is a valid date in gregorian calendar  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/checkdate
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Pyerre
    // *     example 1: checkdate(12, 31, 2000);
    // *     returns 1: true
    // *     example 2: checkdate(2, 29, 2001);
    // *     returns 2: false
    // *     example 3: checkdate(03, 31, 2008);
    // *     returns 3: true
    // *     example 4: checkdate(1, 390, 2000);
    // *     returns 4: false
    var myDate = new Date();
    myDate.setFullYear( year, (month - 1), day );

    return ((myDate.getMonth()+1) == month && day<32); 
}

function date ( format, timestamp ) {
    // Format a local date/time  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/date
    // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
    // +      parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: MeEtc (http://yass.meetcweb.com)
    // +   improved by: Brad Touesnard
    // +   improved by: Tim Wiel
    // +   improved by: Bryan Elliott
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: David Randall
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   derived from: gettimeofday
    // %        note 1: Uses global: php_js to store the default timezone
    // *     example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400);
    // *     returns 1: '09:09:40 m is month'
    // *     example 2: date('F j, Y, g:i a', 1062462400);
    // *     returns 2: 'September 2, 2003, 2:26 am'
    // *     example 3: date('Y W o', 1062462400);
    // *     returns 3: '2003 36 2003'
    // *     example 4: x = date('Y m d', (new Date()).getTime()/1000); // 2009 01 09
    // *     example 4: (x+'').length == 10
    // *     returns 4: true
    var jsdate=(
        (typeof(timestamp) == 'undefined') ? new Date() : // Not provided
        (typeof(timestamp) == 'number') ? new Date(timestamp*1000) : // UNIX timestamp
        new Date(timestamp) // Javascript Date()
    ); // , tal=[]
    var pad = function(n, c){
        if( (n = n + "").length < c ) {
            return new Array(++c - n.length).join("0") + n;
        } else {
            return n;
        }
    };
    var _dst = function (t) {
        // Calculate Daylight Saving Time (derived from gettimeofday() code)
        var dst=0;
        var jan1 = new Date(t.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
        var june1 = new Date(t.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
        var temp = jan1.toUTCString();
        var jan2 = new Date(temp.slice(0, temp.lastIndexOf(' ')-1));
        temp = june1.toUTCString();
        var june2 = new Date(temp.slice(0, temp.lastIndexOf(' ')-1));
        var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
        var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);

        if (std_time_offset === daylight_time_offset) {
            dst = 0; // daylight savings time is NOT observed
        }
        else {
            // positive is southern, negative is northern hemisphere
            var hemisphere = std_time_offset - daylight_time_offset;
            if (hemisphere >= 0) {
                std_time_offset = daylight_time_offset;
            }
            dst = 1; // daylight savings time is observed
        }
        return dst;
    };
    var ret = '';
    var txt_weekdays = ["Sunday","Monday","Tuesday","Wednesday",
        "Thursday","Friday","Saturday"];
    var txt_ordin = {1:"st",2:"nd",3:"rd",21:"st",22:"nd",23:"rd",31:"st"};
    var txt_months =  ["", "January", "February", "March", "April",
        "May", "June", "July", "August", "September", "October", "November",
        "December"];

    var f = {
        // Day
            d: function(){
                return pad(f.j(), 2);
            },
            D: function(){
                var t = f.l();
                return t.substr(0,3);
            },
            j: function(){
                return jsdate.getDate();
            },
            l: function(){
                return txt_weekdays[f.w()];
            },
            N: function(){
                return f.w() + 1;
            },
            S: function(){
                return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th';
            },
            w: function(){
                return jsdate.getDay();
            },
            z: function(){
                return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0;
            },

        // Week
            W: function(){
                var a = f.z(), b = 364 + f.L() - a;
                var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;

                if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
                    return 1;
                } 
                if(a <= 2 && nd >= 4 && a >= (6 - nd)){
                    nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                    return date("W", Math.round(nd2.getTime()/1000));
                }
                return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
            },

        // Month
            F: function(){
                return txt_months[f.n()];
            },
            m: function(){
                return pad(f.n(), 2);
            },
            M: function(){
                var t = f.F();
                return t.substr(0,3);
            },
            n: function(){
                return jsdate.getMonth() + 1;
            },
            t: function(){
                var n;
                if( (n = jsdate.getMonth() + 1) == 2 ){
                    return 28 + f.L();
                }
                if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
                    return 31;
                }
                return 30;
            },

        // Year
            L: function(){
                var y = f.Y();
                return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0;
            },
            o: function(){
                if (f.n() === 12 && f.W() === 1) {
                    return jsdate.getFullYear()+1;
                }
                if (f.n() === 1 && f.W() >= 52) {
                    return jsdate.getFullYear()-1;
                }
                return jsdate.getFullYear();
            },
            Y: function(){
                return jsdate.getFullYear();
            },
            y: function(){
                return (jsdate.getFullYear() + "").slice(2);
            },

        // Time
            a: function(){
                return jsdate.getHours() > 11 ? "pm" : "am";
            },
            A: function(){
                return f.a().toUpperCase();
            },
            B: function(){
                // peter paul koch:
                var off = (jsdate.getTimezoneOffset() + 60)*60;
                var theSeconds = (jsdate.getHours() * 3600) +
                                 (jsdate.getMinutes() * 60) +
                                  jsdate.getSeconds() + off;
                var beat = Math.floor(theSeconds/86.4);
                if (beat > 1000) {
                    beat -= 1000;
                }
                if (beat < 0) {
                    beat += 1000;
                }
                if ((String(beat)).length == 1) {
                    beat = "00"+beat;
                }
                if ((String(beat)).length == 2) {
                    beat = "0"+beat;
                }
                return beat;
            },
            g: function(){
                return jsdate.getHours() % 12 || 12;
            },
            G: function(){
                return jsdate.getHours();
            },
            h: function(){
                return pad(f.g(), 2);
            },
            H: function(){
                return pad(jsdate.getHours(), 2);
            },
            i: function(){
                return pad(jsdate.getMinutes(), 2);
            },
            s: function(){
                return pad(jsdate.getSeconds(), 2);
            },
            u: function(){
                return pad(jsdate.getMilliseconds()*1000, 6);
            },

        // Timezone
            e: function () {
/*                var abbr='', i=0;
                if (this.php_js && this.php_js.default_timezone) {
                    return this.php_js.default_timezone;
                }
                if (!tal.length) {
                    tal = timezone_abbreviations_list();
                }
                for (abbr in tal) {
                    for (i=0; i < tal[abbr].length; i++) {
                        if (tal[abbr][i].offset === -jsdate.getTimezoneOffset()*60) {
                            return tal[abbr][i].timezone_id;
                        }
                    }
                }
*/
                return 'UTC';
            },
            I: function(){
                return _dst(jsdate);
            },
            O: function(){
               var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
               t = (jsdate.getTimezoneOffset() > 0) ? "-"+t : "+"+t;
               return t;
            },
            P: function(){
                var O = f.O();
                return (O.substr(0, 3) + ":" + O.substr(3, 2));
            },
            T: function () {
/*                var abbr='', i=0;
                if (!tal.length) {
                    tal = timezone_abbreviations_list();
                }
                if (this.php_js && this.php_js.default_timezone) {
                    for (abbr in tal) {
                        for (i=0; i < tal[abbr].length; i++) {
                            if (tal[abbr][i].timezone_id === this.php_js.default_timezone) {
                                return abbr.toUpperCase();
                            }
                        }
                    }
                }
                for (abbr in tal) {
                    for (i=0; i < tal[abbr].length; i++) {
                        if (tal[abbr][i].offset === -jsdate.getTimezoneOffset()*60) {
                            return abbr.toUpperCase();
                        }
                    }
                }
*/
                return 'UTC';
            },
            Z: function(){
               return -jsdate.getTimezoneOffset()*60;
            },

        // Full Date/Time
            c: function(){
                return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P();
            },
            r: function(){
                return f.D()+', '+f.d()+' '+f.M()+' '+f.Y()+' '+f.H()+':'+f.i()+':'+f.s()+' '+f.O();
            },
            U: function(){
                return Math.round(jsdate.getTime()/1000);
            }
    };

    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
        if( t!=s ){
            // escaped
            ret = s;
        } else if( f[s] ){
            // a date function exists
            ret = f[s]();
        } else{
            // nothing special
            ret = s;
        }
        return ret;
    });
}

function doubleval( mixed_var ) {
    // !No description available for doubleval. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/doubleval
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    //  -   depends on: floatval
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: doubleval(186);
    // *     returns 1: 186.00
    return this.floatval(mixed_var);
}

function echo ( ) {
    // !No description available for echo. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.2214
    // discuss at: http://phpjs.org/functions/echo
    // +   original by: Philip Peterson
    // +   improved by: echo is bad
    // +   improved by: Nate
    // +    revised by: Der Simon (http://innerdom.sourceforge.net/)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Eugene Bulkin (http://doubleaw.com/)
    // %        note 1: The function still has issues with outputting certain kinds of XML, such as
    // %        note 1: attributes defined with apostrophes, or creating namespaced XML, etc.
    // %        note 1: We might at some point solve this by building on http://code.google.com/p/jssaxparser
    // %        note 1: and using that, though it would be even larger; if browsers start to support
    // %        note 1: DOM Level 3 Load and Save (parsing/serializing), we wouldn't need any
    // %        note 1: such long code (even most of the code below).
    // %        note 2: InnerHTML() is better because it works (and it's fast),
    // %        note 2: but using innerHTML on the BODY is very dangerous because
    // %        note 2: you will break all references to HTMLElements that were done before
    // *     example 1: echo('Hello', 'World');
    // *     returns 1: undefined
    
    var arg = '', argc = arguments.length, argv = arguments, i = 0;
	var d = this.window.document;
	
    var stringToDOM = function (q){
        var s = function(a){
            return a.replace(/&amp;/g,'&').replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&nbsp;/g,' ').replace(/&quot;/g,'"');
        };
        var t = function(a){
            return a.replace(/ /g,'');
        };
        var u = function(a){
            var b,c,e,f,g,h,i;
            b=d.createDocumentFragment();
            c=a.indexOf(' ');
            if (c === -1) {
                b.appendChild(d.createElement(a.toLowerCase()));
            } else {
                i = t(a.substring(0,c)).toLowerCase();
                a = a.substr(c+1);
                b.appendChild(d.createElement(i));
                while(a.length){
                    e=a.indexOf('=');
                    if(e>=0){
                        f=t(a.substring(0,e)).toLowerCase();
                        g=a.indexOf('"');
                        a=a.substr(g+1);
                        g=a.indexOf('"');
                        h=s(a.substring(0,g));
                        a=a.substr(g+2);
                        b.lastChild.setAttribute(f,h);
                     }else{
                        break;
                    }
                }
            }
            return b;
        };
        var v = function(a,b,c){
            var e,f;
            e=b;
            c=c.toLowerCase();
            f=e.indexOf('</'+c+'>');
            a=a.concat(e.substring(0,f));
            e=e.substr(f);
            while(a.indexOf('<'+c)!=-1){
                a=a.substr(a.indexOf('<'+c));
                a=a.substr(a.indexOf('>')+1);
                e=e.substr(e.indexOf('>')+1);
                f=e.indexOf('</'+c+'>');
                a=a.concat(e.substring(0,f));
                e=e.substr(f);
            }
            return b.length-e.length;
        };
        var w = function(a){
            var b,c,e,f,g,h,i,j,k,l,m,n,o,p,q;
            b=d.createDocumentFragment();
            while(a&&a.length){
                c=a.indexOf('<');
                if(c===-1){
                    a=s(a);
                    b.appendChild(d.createTextNode(a));
                    a=null;
                } else if(c){
                    q=s(a.substring(0,c));
                    b.appendChild(d.createTextNode(q));
                    a=a.substr(c);
                } else{
                    e=a.indexOf('<!--');
                    if(!e){
                        f=a.indexOf('-->');
                        g=a.substring(4,f);
                        g=s(g);
                        b.appendChild(d.createComment(g));
                        a=a.substr(f+3);
                    } else{
                        h=a.indexOf('>');
                        if(a.substring(h-1,h)==='/'){
                            i=a.indexOf('/>');
                            j=a.substring(1,i);
                            b.appendChild(u(j));
                            a=a.substr(i+2);
                        } else{
                            k=a.indexOf('>');
                            l=a.substring(1,k);
                            m=d.createDocumentFragment();
                            m.appendChild(u(l));
                            a=a.substr(k+1);
                            n=a.substring(0,a.indexOf('</'));
                            a=a.substr(a.indexOf('</'));
                            if(n.indexOf('<')!=-1){
                                o=m.lastChild.nodeName;
                                p=v(n,a,o);
                                n=n.concat(a.substring(0,p));
                                a=a.substr(p);
                            }
                            a=a.substr(a.indexOf('>')+1);
                            m.lastChild.appendChild(w(n));
                            b.appendChild(m);
                        }
                    }
                }
            }
            return b;
        };
        return w(q);
    };

    for (i = 0; i < argc; i++ ) {
        arg = argv[i];
        if (d.createDocumentFragment && d.createTextNode && d.appendChild) {
            if (d.body) {
                d.body.appendChild(stringToDOM(arg));
            } else {
                d.documentElement.appendChild(stringToDOM(arg));
            }
        } else if (d.write) {
            d.write(arg);
        } else {
            print(arg);
        }
    }
}

function floatval(mixed_var) {
    // +   original by: Michael White (http://getsprink.com)
    // %        note 1: The native parseFloat() method of JavaScript returns NaN when it encounters a string before an int or float value.
    // *     example 1: floatval('150.03_page-section');
    // *     returns 1: 150.03
    // *     example 2: floatval('page: 3');
    // *     returns 2: 0
    // *     example 2: floatval('-50 + 8');
    // *     returns 2: -50
    return (parseFloat(mixed_var) || 0);
}

function get_defined_vars() {
    // Returns an associative array of names and values of all currently defined variable names (variables in the current scope)  
    // 
    // version: 905.1721
    // discuss at: http://phpjs.org/functions/get_defined_vars
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // %        note 1: Test case 1: If get_defined_vars can find itself in the defined vars, it worked :)
    // *     example 1: function test_in_array(array, p_val) {for(var i = 0, l = array.length; i < l; i++) {if(array[i] == p_val) return true;} return false;}
    // *     example 1: funcs = get_defined_vars();
    // *     example 1: found = test_in_array(funcs, 'get_defined_vars');
    // *     results 1: found == true
    var i = '', arr = [], already = {};

    for (i in this.window) {
        try {
            if (typeof this.window[i] === 'function') {
                if (!already[i]) {
                    already[i] = 1;
                    arr.push(i);
                }
            }
            else if (typeof this.window[i] === 'object') {
                for (var j in this.window[i]) {
                    if (typeof this.window[j] === 'function' && this.window[j] && !already[j]) {
                        already[j] = 1;
                        arr.push(j);
                    }
                }
            }
        }
        catch (e) {

        }
    }

    return arr;
}

function get_headers(url, format) {
    // +   original by: Paulo Ricardo F. Santos
    // +    bugfixed by: Brett Zamir (http://brettz9.blogspot.com)
    // %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain.
    // %        note 1: Synchronous so may lock up browser, mainly here for study purposes.
    // *     example 1: get_headers('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm')[0];
    // *     returns 1: 'Date: Wed, 13 May 2009 23:53:11 GMT'
    var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    if (!req) {
        throw new Error('XMLHttpRequest not supported');
    }
    var tmp, headers, pair, i, j = 0;

    req.open('HEAD', url, false);
    req.send(null);

    if (req.readyState < 3) {
        return false;
    }

    tmp = req.getAllResponseHeaders();
    tmp = tmp.split('\n');
    tmp = this.array_filter(tmp, function (value) { return value.substring(1) !== ''; });
    headers = format ? {} : [];

    for (i in tmp) {
        if (format) {
            pair = tmp[i].split(':');
            headers[pair.splice(0, 1)] = pair.join(':').substring(1);
        } else {
            headers[j++] = tmp[i];
        }
    }
    return headers;
}

function get_html_translation_table(table, quote_style) {
    // Returns the internal translation table used by htmlspecialchars and htmlentities  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/get_html_translation_table
    // +   original by: Philip Peterson
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: noname
    // +   bugfixed by: Alex
    // +   bugfixed by: Marco
    // +   bugfixed by: madipta
    // +   improved by: KELAN
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // %          note: It has been decided that we're not going to add global
    // %          note: dependencies to php.js. Meaning the constants are not
    // %          note: real constants, but strings instead. integers are also supported if someone
    // %          note: chooses to create the constants themselves.
    // *     example 1: get_html_translation_table('HTML_SPECIALCHARS');
    // *     returns 1: {'"': '&quot;', '&': '&amp;', '<': '&lt;', '>': '&gt;'}
    
    var entities = {}, histogram = {}, decimal = 0, symbol = '';
    var constMappingTable = {}, constMappingQuoteStyle = {};
    var useTable = {}, useQuoteStyle = {};
    
    // Translate arguments
    constMappingTable[0]      = 'HTML_SPECIALCHARS';
    constMappingTable[1]      = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';

    useTable 	  = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT';

    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error("Table: "+useTable+' not supported');
        // return false;
    }

    // ascii decimals for better compatibility
    entities['38'] = '&amp;';
    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {
        entities['39'] = '&#039;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';

    if (useTable === 'HTML_ENTITIES') {
	    entities['160'] = '&nbsp;';
	    entities['161'] = '&iexcl;';
	    entities['162'] = '&cent;';
	    entities['163'] = '&pound;';
	    entities['164'] = '&curren;';
	    entities['165'] = '&yen;';
	    entities['166'] = '&brvbar;';
	    entities['167'] = '&sect;';
	    entities['168'] = '&uml;';
	    entities['169'] = '&copy;';
	    entities['170'] = '&ordf;';
	    entities['171'] = '&laquo;';
	    entities['172'] = '&not;';
	    entities['173'] = '&shy;';
	    entities['174'] = '&reg;';
	    entities['175'] = '&macr;';
	    entities['176'] = '&deg;';
	    entities['177'] = '&plusmn;';
	    entities['178'] = '&sup2;';
	    entities['179'] = '&sup3;';
	    entities['180'] = '&acute;';
	    entities['181'] = '&micro;';
	    entities['182'] = '&para;';
	    entities['183'] = '&middot;';
	    entities['184'] = '&cedil;';
	    entities['185'] = '&sup1;';
	    entities['186'] = '&ordm;';
	    entities['187'] = '&raquo;';
	    entities['188'] = '&frac14;';
	    entities['189'] = '&frac12;';
	    entities['190'] = '&frac34;';
	    entities['191'] = '&iquest;';
	    entities['192'] = '&Agrave;';
	    entities['193'] = '&Aacute;';
	    entities['194'] = '&Acirc;';
	    entities['195'] = '&Atilde;';
	    entities['196'] = '&Auml;';
	    entities['197'] = '&Aring;';
	    entities['198'] = '&AElig;';
	    entities['199'] = '&Ccedil;';
	    entities['200'] = '&Egrave;';
	    entities['201'] = '&Eacute;';
	    entities['202'] = '&Ecirc;';
	    entities['203'] = '&Euml;';
	    entities['204'] = '&Igrave;';
	    entities['205'] = '&Iacute;';
	    entities['206'] = '&Icirc;';
	    entities['207'] = '&Iuml;';
	    entities['208'] = '&ETH;';
	    entities['209'] = '&Ntilde;';
	    entities['210'] = '&Ograve;';
	    entities['211'] = '&Oacute;';
	    entities['212'] = '&Ocirc;';
	    entities['213'] = '&Otilde;';
	    entities['214'] = '&Ouml;';
	    entities['215'] = '&times;';
	    entities['216'] = '&Oslash;';
	    entities['217'] = '&Ugrave;';
	    entities['218'] = '&Uacute;';
	    entities['219'] = '&Ucirc;';
	    entities['220'] = '&Uuml;';
	    entities['221'] = '&Yacute;';
	    entities['222'] = '&THORN;';
	    entities['223'] = '&szlig;';
	    entities['224'] = '&agrave;';
	    entities['225'] = '&aacute;';
	    entities['226'] = '&acirc;';
	    entities['227'] = '&atilde;';
	    entities['228'] = '&auml;';
	    entities['229'] = '&aring;';
	    entities['230'] = '&aelig;';
	    entities['231'] = '&ccedil;';
	    entities['232'] = '&egrave;';
	    entities['233'] = '&eacute;';
	    entities['234'] = '&ecirc;';
	    entities['235'] = '&euml;';
	    entities['236'] = '&igrave;';
	    entities['237'] = '&iacute;';
	    entities['238'] = '&icirc;';
	    entities['239'] = '&iuml;';
	    entities['240'] = '&eth;';
	    entities['241'] = '&ntilde;';
	    entities['242'] = '&ograve;';
	    entities['243'] = '&oacute;';
	    entities['244'] = '&ocirc;';
	    entities['245'] = '&otilde;';
	    entities['246'] = '&ouml;';
	    entities['247'] = '&divide;';
	    entities['248'] = '&oslash;';
	    entities['249'] = '&ugrave;';
	    entities['250'] = '&uacute;';
	    entities['251'] = '&ucirc;';
	    entities['252'] = '&uuml;';
	    entities['253'] = '&yacute;';
	    entities['254'] = '&thorn;';
	    entities['255'] = '&yuml;';
    }
    
    // ascii decimals to real symbols
    for (decimal in entities) {
        symbol = String.fromCharCode(decimal);
        histogram[symbol] = entities[decimal];
    }
    
    return histogram;
}

function getdate(timestamp) {
    // Get date/time information  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/getdate
    // +   original by: Paulo Ricardo F. Santos
    // *     example 1: getdate(1055901520);
    // *     returns 1: {'seconds': 40, 'minutes': 58, 'hours': 21, 'mday': 17, 'wday': 2, 'mon': 6, 'year': 2003, 'yday': 167, 'weekday': 'Tuesday', 'month': 'June', '0': 1055901520}
    var _w = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var _m = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var d = (typeof timestamp == 'number') ? new Date(timestamp * 1000) : new Date();
    var w = d.getDay();
    var m = d.getMonth();
    var y = d.getFullYear();
    var r = {};

    r.seconds = d.getSeconds();
    r.minutes = d.getMinutes();
    r.hours = d.getHours();
    r.mday = d.getDate();
    r.wday = w;
    r.mon = m + 1;
    r.year = y;
    r.yday = Math.floor((d - (new Date(y, 0, 1))) / 86400000);
    r.weekday = _w[w];
    r.month = _m[m];
    r['0'] = parseInt(d.getTime() / 1000, 10);

    return r;
}

function html_entity_decode( string, quote_style ) {
    // Convert all HTML entities to their applicable characters  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/html_entity_decode
    // +   original by: john (http://www.jd-tech.net)
    // +      input by: ger
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: marc andreu
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: get_html_translation_table
    // *     example 1: html_entity_decode('Kevin &amp; van Zonneveld');
    // *     returns 1: 'Kevin & van Zonneveld'
    // *     example 2: html_entity_decode('&amp;lt;');
    // *     returns 2: '&lt;'
    var histogram = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (histogram = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }

    // &amp; must be the last character when decoding!
    delete(histogram['&']);
    histogram['&'] = '&amp;';

    for (symbol in histogram) {
        entity = histogram[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }
    
    return tmp_str;
}

function htmlentities (string, quote_style) {
    // Convert all applicable characters to HTML entities  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/htmlentities
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: nobbler
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: get_html_translation_table
    // *     example 1: htmlentities('Kevin & van Zonneveld');
    // *     returns 1: 'Kevin &amp; van Zonneveld'
    // *     example 2: htmlentities("foo'bar","ENT_QUOTES");
    // *     returns 2: 'foo&#039;bar'
    var histogram = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (histogram = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }
    
    for (symbol in histogram) {
        entity = histogram[symbol];
        tmp_str = tmp_str.split(symbol).join(entity);
    }
    
    return tmp_str;
}

function htmlspecialchars (string, quote_style) {
    // Convert special characters to HTML entities  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/htmlspecialchars
    // +   original by: Mirek Slugen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Nathan
    // +   bugfixed by: Arno
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: get_html_translation_table
    // *     example 1: htmlspecialchars("<a href='test'>Test</a>", 'ENT_QUOTES');
    // *     returns 1: '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'
    var histogram = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (histogram = this.get_html_translation_table('HTML_SPECIALCHARS', quote_style))) {
        return false;
    }
    
    for (symbol in histogram) {
        entity = histogram[symbol];
        tmp_str = tmp_str.split(symbol).join(entity);
    }
    
    return tmp_str;
}

function htmlspecialchars_decode(string, quote_style) {
    // Convert special HTML entities back to characters  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/htmlspecialchars_decode
    // +   original by: Mirek Slugen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Mateusz "loonquawl" Zalega
    // +      input by: ReverseSyntax
    // +      input by: Slawomir Kaniecki
    // +      input by: Scott Cariss
    // +      input by: Francois
    // +   bugfixed by: Onno Marsman
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: get_html_translation_table
    // *     example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
    // *     returns 1: '<p>this -> &quot;</p>'
    var histogram = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();
    
    if (false === (histogram = this.get_html_translation_table('HTML_SPECIALCHARS', quote_style))) {
        return false;
    }

    // &amp; must be the last character when decoding!
    delete(histogram['&']);
    histogram['&'] = '&amp;';

    for (symbol in histogram) {
        entity = histogram[symbol];
        tmp_str = tmp_str.split(entity).join(symbol);
    }
    
    return tmp_str;
}

function http_build_query( formdata, numeric_prefix, arg_separator ) {
    // Generates a form-encoded query string from an associative array or object.  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/http_build_query
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Legaev Andrey
    // +   improved by: Michael White (http://getsprink.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: stag019
    // -    depends on: urlencode
    // *     example 1: http_build_query({foo: 'bar', php: 'hypertext processor', baz: 'boom', cow: 'milk'}, '', '&amp;');
    // *     returns 1: 'foo=bar&amp;php=hypertext+processor&amp;baz=boom&amp;cow=milk'
    // *     example 2: http_build_query({'php': 'hypertext processor', 0: 'foo', 1: 'bar', 2: 'baz', 3: 'boom', 'cow': 'milk'}, 'myvar_');
    // *     returns 2: 'php=hypertext+processor&myvar_0=foo&myvar_1=bar&myvar_2=baz&myvar_3=boom&cow=milk'
    var value, key, tmp = [];

    var _http_build_query_helper = function (key, val, arg_separator) {
        var k, tmp = [];
        if (val === true) {
            val = "1";
        } else if (val === false) {
            val = "0";
        }
        if (typeof(val) == "array" || typeof(val) == "object") {
            for (k in val) {
                if(val[k] !== null) {
                    tmp.push(_http_build_query_helper(key + "[" + k + "]", val[k], arg_separator));
                }
            }
            return tmp.join(arg_separator);
        } else if(typeof(val) != "function") {
            return this.urlencode(key) + "=" + this.urlencode(val);
        }
    };

    if (!arg_separator) {
        arg_separator = "&";
    }
    for (key in formdata) {
        value = formdata[key];
        if (numeric_prefix && !isNaN(key)) {
            key = String(numeric_prefix) + key;
        }
        tmp.push(_http_build_query_helper(key, value, arg_separator));
    }

    return tmp.join(arg_separator);
}

function intval( mixed_var, base ) {
    // Get the integer value of a variable using the optional base for the conversion  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/intval
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: stensi
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: intval('Kevin van Zonneveld');
    // *     returns 1: 0
    // *     example 2: intval(4.2);
    // *     returns 2: 4
    // *     example 3: intval(42, 8);
    // *     returns 3: 42
    // *     example 4: intval('09');
    // *     returns 4: 9
    var tmp;

    var type = typeof( mixed_var );

    if(type == 'boolean'){
        if (mixed_var == true) {
            return 1;
        } else {
            return 0;
        }
    } else if(type == 'string'){
        tmp = parseInt(mixed_var * 1, 10);
        if(isNaN(tmp) || !isFinite(tmp)){
            return 0;
        } else{
            return tmp.toString(base || 10);
        }
    } else if(type == 'number' && isFinite(mixed_var) ){
        return Math.floor(mixed_var);
    } else{
        return 0;
    }
}

function ip2long ( ip_address ) {
    // Converts a string containing an (IPv4) Internet Protocol dotted address into a proper address  
    // 
    // version: 901.714
    // discuss at: http://phpjs.org/functions/ip2long
    // +   original by: Waldo Malqui Silva
    // +   improved by: Victor
    // *     example 1: ip2long( '192.0.34.166' );
    // *     returns 1: 3221234342
    
    var output = false;
    var parts = [];
    if (ip_address.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/)) {
        parts  = ip_address.split('.');
        output = ( parts[0] * 16777216 +
        ( parts[1] * 65536 ) +
        ( parts[2] * 256 ) +
        ( parts[3] * 1 ) );
    }
     
    return output;
}

function is_bool(mixed_var)
{
    // Returns true if variable is a boolean  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/is_bool
    // +   original by: Onno Marsman
    // *     example 1: is_bool(false);
    // *     returns 1: true
    // *     example 2: is_bool(0);
    // *     returns 2: false
    return (typeof mixed_var == 'boolean');
}

function is_double( mixed_var ) {
    // !No description available for is_double. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/is_double
    // +   original by: Paulo Ricardo F. Santos
    //  -   depends on: is_float
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_double(186.31);
    // *     returns 1: true
    return this.is_float(mixed_var);
}

function is_finite(val) {
    // Returns whether argument is finite  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/is_finite
    // +   original by: Onno Marsman
    // *     example 1: is_finite(Infinity);
    // *     returns 1: false
    // *     example 2: is_finite(-Infinity);
    // *     returns 2: false
    // *     example 3: is_finite(0);
    // *     returns 3: true
    var warningType = '';

    if (val===Infinity || val===-Infinity) {
        return false;
    }

    //Some warnings for maximum PHP compatibility
    if (typeof val=='object') {
        warningType = (val instanceof Array ? 'array' : 'object');
    } else if (typeof val=='string' && !val.match(/^[\+\-]?\d/)) {
        //simulate PHP's behaviour: '-9a' doesn't give a warning, but 'a9' does.
        warningType = 'string';
    }
    if (warningType) {
        throw new Error('Warning: is_finite() expects parameter 1 to be double, '+warningType+' given');
    }

    return true;
}

function is_float( mixed_var ) {
    // Returns true if variable is float point  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/is_float
    // +   original by: Paulo Ricardo F. Santos
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_float(186.31);
    // *     returns 1: true
    return parseFloat(mixed_var * 1) != parseInt(mixed_var * 1, 10);
}

function is_infinite(val) {
    // Returns whether argument is infinite  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/is_infinite
    // +   original by: Onno Marsman
    // *     example 1: is_infinite(Infinity);
    // *     returns 1: true
    // *     example 2: is_infinite(-Infinity);
    // *     returns 2: true
    // *     example 3: is_infinite(0);
    // *     returns 3: false
    var warningType = '';

    if (val===Infinity || val===-Infinity) {
        return true;
    }

    //Some warnings for maximum PHP compatibility
    if (typeof val=='object') {
        warningType = (val instanceof Array ? 'array' : 'object');
    } else if (typeof val=='string' && !val.match(/^[\+\-]?\d/)) {
        //simulate PHP's behaviour: '-9a' doesn't give a warning, but 'a9' does.
        warningType = 'string';
    }
    if (warningType) {
        throw new Error('Warning: is_infinite() expects parameter 1 to be double, '+warningType+' given');
    }

    return false;
}

function is_int( mixed_var ) {
    // !No description available for is_int. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/is_int
    // +   original by: Alex
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Matt Bradley
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_int(23)
    // *     returns 1: true
    // *     example 2: is_int('23')
    // *     returns 2: false
    // *     example 3: is_int(23.5)
    // *     returns 3: false
    // *     example 4: is_int(true)
    // *     returns 4: false
    if (typeof mixed_var !== 'number') {
        return false;
    }

    if (parseFloat(mixed_var) != parseInt(mixed_var, 10)) {
        return false;
    }
    
    return true;
}

function is_integer( mixed_var ) {
    // !No description available for is_integer. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/is_integer
    // +   original by: Paulo Ricardo F. Santos
    //  -   depends on: is_int
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_integer(186.31);
    // *     returns 1: false
    // *     example 2: is_integer(12);
    // *     returns 2: true
    return this.is_int(mixed_var);
}

function is_long( mixed_var ) {
    // Returns true if variable is a long (integer)  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/is_long
    // +   original by: Paulo Ricardo F. Santos
    //  -   depends on: is_float
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_long(186.31);
    // *     returns 1: true
    return this.is_float(mixed_var);
}

function is_nan(val) {
    // Returns whether argument is not a number  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/is_nan
    // +   original by: Onno Marsman
    // +      input by: Robin
    // *     example 1: is_nan(NaN);
    // *     returns 1: true
    // *     example 2: is_nan(0);
    // *     returns 2: false
    var warningType = '';

    if (typeof val=='number' && isNaN(val)) {
        return true;
    }

    //Some errors for maximum PHP compatibility
    if (typeof val=='object') {
        warningType = (val instanceof Array ? 'array' : 'object');
    } else if (typeof val=='string' && !val.match(/^[\+\-]?\d/)) {
        //simulate PHP's behaviour: '-9a' doesn't give a warning, but 'a9' does.
        warningType = 'string';
    }
    if (warningType) {
        throw new Error('Warning: is_nan() expects parameter 1 to be double, '+warningType+' given');
    }

    return false;
}

function is_null( mixed_var ){
    // Returns true if variable is null  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/is_null
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: is_null('23');
    // *     returns 1: false
    // *     example 2: is_null(null);
    // *     returns 2: true
    return ( mixed_var === null );
}

function is_numeric( mixed_var ) {
    // Returns true if value is a number or a numeric string  
    // 
    // version: 904.317
    // discuss at: http://phpjs.org/functions/is_numeric
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: David
    // +   improved by: taith
    // +   bugfixed by: Tim de Koning
    // *     example 1: is_numeric(186.31);
    // *     returns 1: true
    // *     example 2: is_numeric('Kevin van Zonneveld');
    // *     returns 2: false
    // *     example 3: is_numeric('+186.31e2');
    // *     returns 3: true
    // *     example 4: is_numeric('');
    // *     returns 4: false
    if (mixed_var === '') {
        return false;
    }

    return !isNaN(mixed_var * 1);
}

function is_real( mixed_var ) {
    // !No description available for is_real. @php.js developers: Please update the function summary text file.
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/is_real
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    //  -   depends on: is_float
    // %        note 1: 1.0 is simplified to 1 before it can be accessed by the function, this makes
    // %        note 1: it different from the PHP implementation. We can't fix this unfortunately.
    // *     example 1: is_double(186.31);
    // *     returns 1: true
    return this.is_float(mixed_var);
}

function is_scalar( mixed_var ) {
    // Returns true if value is a scalar  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/is_scalar
    // +   original by: Paulo Ricardo F. Santos
    // *     example 1: is_scalar(186.31);
    // *     returns 1: true
    // *     example 2: is_scalar({0: 'Kevin van Zonneveld'});
    // *     returns 2: false
    return (/boolean|number|string/).test(typeof mixed_var);
}

function is_string( mixed_var ){
    // Returns true if variable is a Unicode or binary string  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/is_string
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: is_string('23');
    // *     returns 1: true
    // *     example 2: is_string(23.5);
    // *     returns 2: false
    return (typeof( mixed_var ) == 'string');
}

function lcg_value() {
    // !No description available for lcg_value. @php.js developers: Please update the function summary text file.
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/lcg_value
    // +   original by: Onno Marsman
    return Math.random();
}

function log(arg, base) {
    // Returns the natural logarithm of the number, or the base log if base is specified  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/log
    // +   original by: Onno Marsman
    // *     example 1: log(8723321.4, 7);
    // *     returns 1: 8.212871815082147
    if (base === undefined) {
        return Math.log(arg);
    } else {
        return Math.log(arg)/Math.log(base);
    }
}

function log10(arg) {
    // Returns the base-10 logarithm of the number  
    // 
    // version: 812.316
    // discuss at: http://phpjs.org/functions/log10
    // +   original by: Philip Peterson
    // +   improved by: Onno Marsman
    // +   improved by: Tod Gentille
    // *     example 1: log10(10);
    // *     returns 1: 1
    // *     example 2: log10(1);
    // *     returns 2: 0
    return Math.log(arg)/Math.LN10;
}

function log1p (x) {
    // Returns log(1 + number), computed in a way that accurate even when the value of number is close to zero  
    // 
    // version: 904.317
    // discuss at: http://phpjs.org/functions/log1p
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
	// %          note 1: Precision 'n' can be adjusted as desired
    // *     example 1: log1p(1e-15);
    // *     returns 1: 9.999999999999995e-16

    var ret=0, n = 50; // degree of precision
    if (x <= -1) {
        return '-INF'; // JavaScript style would be to return Number.NEGATIVE_INFINITY
    }
    if (x < 0 || x > 1) {
        return Math.log(1+x);
    }
    for (var i=1; i < n; i++) {
        if ((i % 2) === 0) {
            ret -= Math.pow(x, i)/i;
        }
        else {
            ret += Math.pow(x, i)/i;
        }
    }
    return ret;
}

function long2ip ( proper_address ) {
    // Converts an (IPv4) Internet network address into a string in Internet standard dotted format  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/long2ip
    // +   original by: Waldo Malqui Silva
    // *     example 1: long2ip( 3221234342 );
    // *     returns 1: '192.0.34.166'
    
    var output = false;
    
    if ( !isNaN( proper_address ) && ( proper_address >= 0 || proper_address <= 4294967295 ) ) {
		output = Math.floor(proper_address / Math.pow( 256, 3 ) ) + '.' +
			Math.floor( ( proper_address % Math.pow( 256, 3 ) ) / Math.pow( 256, 2 ) ) + '.' +
			Math.floor( ( ( proper_address % Math.pow( 256, 3 ) )  % Math.pow( 256, 2 ) ) / Math.pow( 256, 1 ) ) + '.' +
			Math.floor( ( ( ( proper_address % Math.pow( 256, 3 ) ) % Math.pow( 256, 2 ) ) % Math.pow( 256, 1 ) ) / Math.pow( 256, 0 ) );
    }
    
    return output;
}

function max() {
    // Return the highest value in an array or a series of arguments  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/max
    // +   original by: Onno Marsman
    // +    revised by: Onno Marsman
    // +    tweaked by: Jack
    // %          note: Long code cause we're aiming for maximum PHP compatibility
    // *     example 1: max(1, 3, 5, 6, 7);
    // *     returns 1: 7
    // *     example 2: max([2, 4, 5]);
    // *     returns 2: 5
    // *     example 3: max(0, 'hello');
    // *     returns 3: 0
    // *     example 4: max('hello', 0);
    // *     returns 4: 'hello'
    // *     example 5: max(-1, 'hello');
    // *     returns 5: 'hello'
    // *     example 6: max([2, 4, 8], [2, 5, 7]);
    // *     returns 6: [2, 5, 7]
    var ar, retVal, i = 0, n = 0;
    var argv = arguments, argc = argv.length;

    var _obj2Array = function(obj) {
        if (obj instanceof Array) {
            return obj;
        } else {
            var ar = [];
            for (var i in obj) {
                ar.push(obj[i]);
            }
            return ar;
        }
    }; //function _obj2Array
    
    var _compare = function(current, next) {
        var i = 0, n = 0, tmp = 0;
        var nl = 0, cl = 0;
        
        if (current === next) {
            return 0;
        } else if (typeof current == 'object') {
            if (typeof next == 'object') {
               current = _obj2Array(current);
               next    = _obj2Array(next);
               cl      = current.length;
               nl      = next.length;
               if (nl > cl) {
                   return 1;
               } else if (nl < cl) {
                   return -1;
               } else {
                   for (i = 0, n = cl; i<n; ++i) {
                       tmp = _compare(current[i], next[i]);
                       if (tmp == 1) {
                           return 1;
                       } else if (tmp == -1) {
                           return -1;
                       }
                   }
                   return 0;
               }
            } else {
               return -1;
            }
        } else if (typeof next == 'object') {
            return 1;
        } else if (isNaN(next) && !isNaN(current)) {
            if (current == 0) {
               return 0;
            } else {
               return (current<0 ? 1 : -1);
            }
        } else if (isNaN(current) && !isNaN(next)) {
            if (next==0) {
               return 0;
            } else {
               return (next>0 ? 1 : -1);
            }
        } else {
            if (next==current) {
               return 0;
            } else {
               return (next>current ? 1 : -1);
            }
        }
    }; //function _compare
    
    if (argc === 0) {
        throw new Error('At least one value should be passed to max()');
    } else if (argc === 1) {
        if (typeof argv[0] === 'object') {
            ar = _obj2Array(argv[0]);
        } else {
            throw new Error('Wrong parameter count for max()');
        }
        if (ar.length === 0) {
            throw new Error('Array must contain at least one element for max()');
        }
    } else {
        ar = argv;
    }
    
    retVal = ar[0];
    for (i=1, n=ar.length; i<n; ++i) {
        if (_compare(retVal, ar[i])==1) {
            retVal = ar[i];
        }
    }
    
    return retVal;
}

function md5 ( str ) {
    // Calculate the md5 hash of a string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/md5
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // + namespaced by: Michael White (http://getsprink.com)
    // +    tweaked by: Jack
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: utf8_encode
    // *     example 1: md5('Kevin van Zonneveld');
    // *     returns 1: '6e658d4bfcb59cc13f96c14450ac40b9'
    var xl;

    var rotateLeft = function(lValue, iShiftBits) {
        return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
    };

    var addUnsigned = function(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
            return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
            if (lResult & 0x40000000) {
                return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            } else {
                return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
            }
        } else {
            return (lResult ^ lX8 ^ lY8);
        }
    };

    var _F = function(x,y,z) { return (x & y) | ((~x) & z); };
    var _G = function(x,y,z) { return (x & z) | (y & (~z)); };
    var _H = function(x,y,z) { return (x ^ y ^ z); };
    var _I = function(x,y,z) { return (y ^ (x | (~z))); };

    var _FF = function(a,b,c,d,x,s,ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_F(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    };

    var _GG = function(a,b,c,d,x,s,ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_G(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    };

    var _HH = function(a,b,c,d,x,s,ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_H(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    };

    var _II = function(a,b,c,d,x,s,ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_I(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    };

    var convertToWordArray = function(str) {
        var lWordCount;
        var lMessageLength = str.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray=new Array(lNumberOfWords-1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (str.charCodeAt(lByteCount)<<lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
    };

    var wordToHex = function(lValue) {
        var wordToHexValue="",wordToHexValue_temp="",lByte,lCount;
        for (lCount = 0;lCount<=3;lCount++) {
            lByte = (lValue>>>(lCount*8)) & 255;
            wordToHexValue_temp = "0" + lByte.toString(16);
            wordToHexValue = wordToHexValue + wordToHexValue_temp.substr(wordToHexValue_temp.length-2,2);
        }
        return wordToHexValue;
    };

    var x=[],
        k,AA,BB,CC,DD,a,b,c,d,
        S11=7, S12=12, S13=17, S14=22,
        S21=5, S22=9 , S23=14, S24=20,
        S31=4, S32=11, S33=16, S34=23,
        S41=6, S42=10, S43=15, S44=21;

    str = this.utf8_encode(str);
    x = convertToWordArray(str);
    a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
    
    xl = x.length;
    for (k=0;k<xl;k+=16) {
        AA=a; BB=b; CC=c; DD=d;
        a=_FF(a,b,c,d,x[k+0], S11,0xD76AA478);
        d=_FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
        c=_FF(c,d,a,b,x[k+2], S13,0x242070DB);
        b=_FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a=_FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
        d=_FF(d,a,b,c,x[k+5], S12,0x4787C62A);
        c=_FF(c,d,a,b,x[k+6], S13,0xA8304613);
        b=_FF(b,c,d,a,x[k+7], S14,0xFD469501);
        a=_FF(a,b,c,d,x[k+8], S11,0x698098D8);
        d=_FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
        c=_FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
        b=_FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a=_FF(a,b,c,d,x[k+12],S11,0x6B901122);
        d=_FF(d,a,b,c,x[k+13],S12,0xFD987193);
        c=_FF(c,d,a,b,x[k+14],S13,0xA679438E);
        b=_FF(b,c,d,a,x[k+15],S14,0x49B40821);
        a=_GG(a,b,c,d,x[k+1], S21,0xF61E2562);
        d=_GG(d,a,b,c,x[k+6], S22,0xC040B340);
        c=_GG(c,d,a,b,x[k+11],S23,0x265E5A51);
        b=_GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a=_GG(a,b,c,d,x[k+5], S21,0xD62F105D);
        d=_GG(d,a,b,c,x[k+10],S22,0x2441453);
        c=_GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
        b=_GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a=_GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
        d=_GG(d,a,b,c,x[k+14],S22,0xC33707D6);
        c=_GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
        b=_GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a=_GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
        d=_GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
        c=_GG(c,d,a,b,x[k+7], S23,0x676F02D9);
        b=_GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a=_HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
        d=_HH(d,a,b,c,x[k+8], S32,0x8771F681);
        c=_HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
        b=_HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a=_HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
        d=_HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
        c=_HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
        b=_HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a=_HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
        d=_HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
        c=_HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
        b=_HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a=_HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
        d=_HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
        c=_HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
        b=_HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a=_II(a,b,c,d,x[k+0], S41,0xF4292244);
        d=_II(d,a,b,c,x[k+7], S42,0x432AFF97);
        c=_II(c,d,a,b,x[k+14],S43,0xAB9423A7);
        b=_II(b,c,d,a,x[k+5], S44,0xFC93A039);
        a=_II(a,b,c,d,x[k+12],S41,0x655B59C3);
        d=_II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
        c=_II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
        b=_II(b,c,d,a,x[k+1], S44,0x85845DD1);
        a=_II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
        d=_II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
        c=_II(c,d,a,b,x[k+6], S43,0xA3014314);
        b=_II(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a=_II(a,b,c,d,x[k+4], S41,0xF7537E82);
        d=_II(d,a,b,c,x[k+11],S42,0xBD3AF235);
        c=_II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
        b=_II(b,c,d,a,x[k+9], S44,0xEB86D391);
        a=addUnsigned(a,AA);
        b=addUnsigned(b,BB);
        c=addUnsigned(c,CC);
        d=addUnsigned(d,DD);
    }

    var temp = wordToHex(a)+wordToHex(b)+wordToHex(c)+wordToHex(d);

    return temp.toLowerCase();
}

function microtime(get_as_float) {
    // Returns either a string or a float containing the current time in seconds and microseconds  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/microtime
    // +   original by: Paulo Ricardo F. Santos
    // *     example 1: timeStamp = microtime(true);
    // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000
    var now = new Date().getTime() / 1000;
    var s = parseInt(now, 10);

    return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}

function min() {
    // Return the lowest value in an array or a series of arguments  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/min
    // +   original by: Onno Marsman
    // +    revised by: Onno Marsman
    // +    tweaked by: Jack
    // %          note: Long code cause we're aiming for maximum PHP compatibility
    // *     example 1: min(1, 3, 5, 6, 7);
    // *     returns 1: 1
    // *     example 2: min([2, 4, 5]);
    // *     returns 2: 2
    // *     example 3: min(0, 'hello');
    // *     returns 3: 0
    // *     example 4: min('hello', 0);
    // *     returns 4: 'hello'
    // *     example 5: min(-1, 'hello');
    // *     returns 5: -1
    // *     example 6: min([2, 4, 8], [2, 5, 7]);
    // *     returns 6: [2, 4, 8]
    
    var ar, retVal, i = 0, n = 0;
    var argv = arguments, argc = argv.length;

    var _obj2Array = function(obj) {
        if (obj instanceof Array) {
            return obj;
        } else {
            var ar = [];
            for (var i in obj) {
                ar.push(obj[i]);
            }
            return ar;
        }
    }; //function _obj2Array
    
    var _compare = function(current, next) {
        var i = 0, n = 0, tmp = 0;
        var nl = 0, cl = 0;
        
        if (current === next) {
            return 0;
        } else if (typeof current == 'object') {
            if (typeof next == 'object') {
               current = _obj2Array(current);
               next    = _obj2Array(next);
               cl      = current.length;
               nl      = next.length;
               if (nl > cl) {
                   return 1;
               } else if (nl < cl) {
                   return -1;
               } else {
                   for (i = 0, n = cl; i<n; ++i) {
                       tmp = _compare(current[i], next[i]);
                       if (tmp == 1) {
                           return 1;
                       } else if (tmp == -1) {
                           return -1;
                       }
                   }
                   return 0;
               }
            } else {
               return -1;
            }
        } else if (typeof next == 'object') {
            return 1;
        } else if (isNaN(next) && !isNaN(current)) {
            if (current == 0) {
               return 0;
            } else {
               return (current<0 ? 1 : -1);
            }
        } else if (isNaN(current) && !isNaN(next)) {
            if (next==0) {
               return 0;
            } else {
               return (next>0 ? 1 : -1);
            }
        } else {
            if (next==current) {
               return 0;
            } else {
               return (next>current ? 1 : -1);
            }
        }
    }; //function _compare
    
    if (argc === 0) {
        throw new Error('At least one value should be passed to min()');
    } else if (argc === 1) {
        if (typeof argv[0] === 'object') {
            ar = _obj2Array(argv[0]);
        } else {
            throw new Error('Wrong parameter count for min()');
        }
        if (ar.length === 0) {
            throw new Error('Array must contain at least one element for min()');
        }
    } else {
        ar = argv;
    }
    
    retVal = ar[0];
    for (i=1, n=ar.length; i<n; ++i) {
        if (_compare(retVal, ar[i])==-1) {
            retVal = ar[i];
        }
    }
    
    return retVal;
}

function mktime() {
    // Get UNIX timestamp for a date  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/mktime
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: baris ozdil
    // +      input by: gabriel paderni
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: FGFEmperor
    // +      input by: Yannoo
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: jakes
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Marc Palau
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // *     example 1: mktime(14, 10, 2, 2, 1, 2008);
    // *     returns 1: 1201871402
    // *     example 2: mktime(0, 0, 0, 0, 1, 2008);
    // *     returns 2: 1196463600
    // *     example 3: make = mktime();
    // *     example 3: td = new Date();
    // *     example 3: real = Math.floor(td.getTime()/1000);
    // *     example 3: diff = (real - make);
    // *     results 3: diff < 5
    // *     example 4: mktime(0, 0, 0, 13, 1, 1997)
    // *     returns 4: 883609200
    // *     example 5: mktime(0, 0, 0, 1, 1, 1998)
    // *     returns 5: 883609200
    // *     example 6: mktime(0, 0, 0, 1, 1, 98)
    // *     returns 6: 883609200
    var no=0, i = 0, ma=0, mb=0, d = new Date(), dn = new Date(), argv = arguments, argc = argv.length;

    var dateManip = {
        0: function(tt){ return d.setHours(tt); },
        1: function(tt){ return d.setMinutes(tt); },
        2: function(tt){ var set = d.setSeconds(tt); mb = d.getDate() - dn.getDate(); return set;},
        3: function(tt){ var set = d.setMonth(parseInt(tt, 10)-1); ma = d.getFullYear() - dn.getFullYear(); return set;},
        4: function(tt){ return d.setDate(tt+mb);},
        5: function(tt){
            if (tt >= 0 && tt <= 69) {
                tt += 2000;
            }
            else if (tt >= 70 && tt <= 100) {
                tt += 1900;
            }
            return d.setFullYear(tt+ma);
        }
        // 7th argument (for DST) is deprecated
    };

    for( i = 0; i < argc; i++ ){
        no = parseInt(argv[i]*1, 10);
        if (isNaN(no)) {
            return false;
        } else {
            // arg is number, let's manipulate date object
            if(!dateManip[i](no)){
                // failed
                return false;
            }
        }
    }
    for (i = argc; i < 6; i++) {
        switch(i) {
            case 0:
                no = dn.getHours();
                break;
            case 1:
                no = dn.getMinutes();
                break;
            case 2:
                no = dn.getSeconds();
                break;
            case 3:
                no = dn.getMonth()+1;
                break;
            case 4:
                no = dn.getDate();
                break;
            case 5:
                no = dn.getFullYear();
                break;
        }
        dateManip[i](no);
    }

    return Math.floor(d.getTime()/1000);
}

function mt_getrandmax()
{
    // Returns the maximum value a random number from Mersenne Twister can have  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/mt_getrandmax
    // +   original by: Onno Marsman
    // *     example 1: mt_getrandmax();
    // *     returns 1: 2147483647
    return 2147483647;
}

function mt_rand( min, max ) {
    // Returns a random number from Mersenne Twister  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/mt_rand
    // +   original by: Onno Marsman
    // *     example 1: mt_rand(1, 1);
    // *     returns 1: 1
    var argc = arguments.length;
    if (argc === 0) {
        min = 0;
        max = 2147483647;
    } else if (argc === 1) {
        throw new Error('Warning: mt_rand() expects exactly 2 parameters, 1 given');
    }
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function nl2br (str, is_xhtml) {
    // Converts newlines to HTML line breaks  
    // 
    // version: 903.3016
    // discuss at: http://phpjs.org/functions/nl2br
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Philip Peterson
    // +   improved by: Onno Marsman
    // +   improved by: Atli Þór
    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: nl2br('Kevin\nvan\nZonneveld');
    // *     returns 1: 'Kevin<br />\nvan<br />\nZonneveld'
    // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
    // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
    // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
    // *     returns 3: '<br />\nOne<br />\nTwo<br />\n<br />\nThree<br />\n'
    var breakTag = '';

    breakTag = '<br />';
    if (typeof is_xhtml != 'undefined' && !is_xhtml) {
        breakTag = '<br>';
    }

    return (str + '').replace(/([^>]?)\n/g, '$1'+ breakTag +'\n');
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    // Formats a number with grouped thousands  
    // 
    // version: 902.1517
    // discuss at: http://phpjs.org/functions/number_format
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // %        note 1: For 1000.55 result with precision 1 in FF/Opera is 1,000.5, but in IE is 1,000.6
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

function octdec (oct_string) {
    // Returns the decimal equivalent of an octal string  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/octdec
    // +   original by: Philippe Baumann
    // *     example 1: octdec('77');
    // *     returns 1: 63
    oct_string = (oct_string+'').replace(/[^0-7]/gi, '');
    return parseInt(oct_string, 8);
}

function parse_url (str, component) {
    // Parse a URL and return its components  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/parse_url
    // +      original by: Steven Levithan (http://blog.stevenlevithan.com)
    // + reimplemented by: Brett Zamir (http://brettz9.blogspot.com)
    // %          note: Based on http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    // %          note: blog post at http://blog.stevenlevithan.com/archives/parseuri
    // %          note: demo at http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    // %          note: Does not replace invaild characters with '_' as in PHP, nor does it return false with
    // %          note: a seriously malformed URL.
    // %          note: Besides function name, is the same as parseUri besides the commented out portion
    // %          note: and the additional section following, as well as our allowing an extra slash after
    // %          note: the scheme/protocol (to allow file:/// as in PHP)
    // *     example 1: parse_url('http://username:password@hostname/path?arg=value#anchor');
    // *     returns 1: {scheme: 'http', host: 'hostname', user: 'username', pass: 'password', path: '/path', query: 'arg=value', fragment: 'anchor'}
    var  o   = {
        strictMode: false,
        key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
        q:   {
            name:   "queryKey",
            parser: /(?:^|&)([^&=]*)=?([^&]*)/g
        },
        parser: {
            strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
            loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-protocol to catch file:/// (should restrict this)
        }
    };
    
    var m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
    uri = {},
    i   = 14;
    while (i--) {uri[o.key[i]] = m[i] || "";}
    // Uncomment the following to use the original more detailed (non-PHP) script
    /*
        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
        if ($1) uri[o.q.name][$1] = $2;
        });
        return uri;
    */

    switch (component) {
        case 'PHP_URL_SCHEME':
            return uri.protocol;
        case 'PHP_URL_HOST':
            return uri.host;
        case 'PHP_URL_PORT':
            return uri.port;
        case 'PHP_URL_USER':
            return uri.user;
        case 'PHP_URL_PASS':
            return uri.password;
        case 'PHP_URL_PATH':
            return uri.path;
        case 'PHP_URL_QUERY':
            return uri.query;
        case 'PHP_URL_FRAGMENT':
            return uri.anchor;
        default:
            var retArr = {};
            if (uri.protocol !== '') {retArr.scheme=uri.protocol;}
            if (uri.host !== '') {retArr.host=uri.host;}
            if (uri.port !== '') {retArr.port=uri.port;}
            if (uri.user !== '') {retArr.user=uri.user;}
            if (uri.password !== '') {retArr.pass=uri.password;}
            if (uri.path !== '') {retArr.path=uri.path;}
            if (uri.query !== '') {retArr.query=uri.query;}
            if (uri.anchor !== '') {retArr.fragment=uri.anchor;}
            return retArr;
    }
}

function pi() {
    // Returns an approximation of pi  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/pi
    // +   original by: Onno Marsman
    // *     example 1: pi(8723321.4);
    // *     returns 1: 3.141592653589793
    return Math.PI;
}

function pow(base, exp) {
    // Returns base raised to the power of exponent. Returns integer result when possible  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/pow
    // +   original by: Onno Marsman
    // *     example 1: pow(8723321.4, 7);
    // *     returns 1: 3.843909168077899e+48
    return Math.pow(base, exp);
}

function preg_grep (pattern, input, flags) {
    // Searches array and returns entries which match regex  
    // 
    // version: 904.317
    // discuss at: http://phpjs.org/functions/preg_grep
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
	// %          note 1: If pass pattern as string, must escape backslashes, even for single quotes
    // %          note 2: The regular expression itself must be expressed JavaScript style
    // %          note 3: It is not recommended to submit the pattern as a string, as we may implement
    // %          note 3:   parsing of PHP-style expressions (flags, etc.) in the future
    // *     example 1: var arr = [1, 4, 4.5, 3, 'a', 4.4];
    // *     example 1: preg_grep("/^(\\d+)?\\.\\d+$/", arr);
    // *     returns 1: {2: 4.5, 5: 4.4}

    var p='', retObj = {};
    var invert = flags === 'PREG_GREP_INVERT' ? true : false;

    if (typeof pattern === 'string') {
        pattern = eval(pattern);
    }

    if (invert) {
        for (p in input) {
            if (!pattern.test(input[p])) {
                retObj[p] = input[p];
            }
        }
    } else {
        for (p in input) {
            if (pattern.test(input[p])) {
                retObj[p] = input[p];
            }
        }
    }

    return retObj;
}

function preg_quote( str ) {
    // Quote regular expression characters plus an optional character  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/preg_quote
    // +   original by: booeyOH
    // +   improved by: Ates Goral (http://magnetiq.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: preg_quote("$40");
    // *     returns 1: '\$40'
    // *     example 2: preg_quote("*RRRING* Hello?");
    // *     returns 2: '\*RRRING\* Hello\?'
    // *     example 3: preg_quote("\\.+*?[^]$(){}=!<>|:");
    // *     returns 3: '\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:'
    return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "\\$1");
}

function print_r( array, return_val ) {
    // Prints out or returns information about the specified variable  
    // 
    // version: 905.2214
    // discuss at: http://phpjs.org/functions/print_r
    // +   original by: Michael White (http://getsprink.com)
    // +   improved by: Ben Bryan
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +      improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: echo
    // *     example 1: print_r(1, true);
    // *     returns 1: 1
    
    var output = "", pad_char = " ", pad_val = 4, d = this.window.document;

    var repeat_char = function (len, pad_char) {
        var str = "";
        for(var i=0; i < len; i++) {
            str += pad_char;
        }
        return str;
    };

    var formatArray = function (obj, cur_depth, pad_val, pad_char) {
        if (cur_depth > 0) {
            cur_depth++;
        }

        var base_pad = repeat_char(pad_val*cur_depth, pad_char);
        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
        var str = "";

        if (typeof obj === 'object' && obj !== null && obj.constructor && obj.constructor.name !== 'PHPJS_Resource') {
            str += "Array\n" + base_pad + "(\n";
            for (var key in obj) {
                if (obj[key] instanceof Array) {
                    str += thick_pad + "["+key+"] => "+formatArray(obj[key], cur_depth+1, pad_val, pad_char);
                } else {
                    str += thick_pad + "["+key+"] => " + obj[key] + "\n";
                }
            }
            str += base_pad + ")\n";
        } else if(obj === null || obj === undefined) {
            str = '';
        } else { // for our "resource" class
            str = obj.toString();
        }

        return str;
    };

    output = formatArray(array, 0, pad_val, pad_char);

    if (return_val !== true) {
        if (d.body) {
            this.echo(output);
        }
        else {
            try {
                d = XULDocument; // We're in XUL, so appending as plain text won't work; trigger an error out of XUL
                this.echo('<pre xmlns="http://www.w3.org/1999/xhtml" style="white-space:pre;">'+output+'</pre>');
            }
            catch(e) {
                this.echo(output); // Outputting as plain text may work in some plain XML
            }
        }
        return true;
    } else {
        return output;
    }
}

function rad2deg(angle) {
    // Converts the radian number to the equivalent number in degrees  
    // 
    // version: 810.117
    // discuss at: http://phpjs.org/functions/rad2deg
    // +   original by: Enrique Gonzalez
    // *     example 1: rad2deg(3.141592653589793);
    // *     returns 1: 180
    
    return (angle/Math.PI) * 180;
}

function rand( min, max ) {
    // Returns a random number  
    // 
    // version: 905.1002
    // discuss at: http://phpjs.org/functions/rand
    // +   original by: Leslie Hoare
    // +   bugfixed by: Onno Marsman
	// %          note 1: See the commented out code below for a version which will work with our experimental (though probably unnecessary) srand() function)
    // *     example 1: rand(1, 1);
    // *     returns 1: 1
    
    var argc = arguments.length;
    if (argc === 0) {
        min = 0;
        max = 2147483647;
    } else if (argc === 1) {
        throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
    }
    return Math.floor(Math.random() * (max - min + 1)) + min;
    
    /*
    // See note above for an explanation of the following alternative code
    
	// +   reimplemented by: Brett Zamir (http://brettz9.blogspot.com)
	// -    depends on: srand
	// %          note 1: This is a very possibly imperfect adaptation from the PHP source code
	var rand_seed, ctx, PHP_RAND_MAX=2147483647; // 0x7fffffff

	if (!this.php_js || this.php_js.rand_seed === undefined) {
		this.srand();
	}
	rand_seed = this.php_js.rand_seed;

	var argc = arguments.length;
    if (argc === 1) {
        throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
    }

	var do_rand = function (ctx) {
		return ((ctx * 1103515245 + 12345) % (PHP_RAND_MAX + 1));
	};

	var php_rand = function (ctxArg) { // php_rand_r
		this.php_js.rand_seed = do_rand(ctxArg);
		return parseInt(this.php_js.rand_seed, 10);
	};

	var number = php_rand(rand_seed);

	if (argc === 2) {
		number = min + parseInt(parseFloat(parseFloat(max) - min + 1.0) * (number/(PHP_RAND_MAX + 1.0)), 10);
    }
	return number;
    */
}

function rawurldecode( str ) {
    // Decodes URL-encodes string  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/rawurldecode
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: rawurldecode('Kevin+van+Zonneveld%21');
    // *     returns 1: 'Kevin+van+Zonneveld!'
    // *     example 2: rawurldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
    // *     returns 2: 'http://kevin.vanzonneveld.net/'
    // *     example 3: rawurldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
    // *     returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'
    // *     example 4: rawurldecode('-22%97bc%2Fbc');
    // *     returns 4: '-22—bc/bc'
    var histogram = {}, ret = str.toString(), unicodeStr='', hexEscStr='';

    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };

    // The histogram is identical to the one in urlencode.
    histogram["'"]   = '%27';
    histogram['(']   = '%28';
    histogram[')']   = '%29';
    histogram['*']   = '%2A';
    histogram['~']   = '%7E';
    histogram['!']   = '%21';


    for (unicodeStr in histogram) {
        hexEscStr = histogram[unicodeStr]; // Switch order when decoding
        ret = replacer(hexEscStr, unicodeStr, ret); // Custom replace. No regexing
    }

    // End with decodeURIComponent, which most resembles PHP's encoding functions
    ret = ret.replace(/%([a-fA-F][0-9a-fA-F])/g, function (all, hex) {return String.fromCharCode('0x'+hex);}); // These Latin-B have the same values in Unicode, so we can convert them like this
    ret = decodeURIComponent(ret);

    return ret;
}

function rawurlencode( str ) {
    // URL-encodes string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/rawurlencode
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Michael Grier
    // +   bugfixed by: Brett Zamir (http://brettz9.blogspot.com)
    // *     example 1: rawurlencode('Kevin van Zonneveld!');
    // *     returns 1: 'Kevin%20van%20Zonneveld%21'
    // *     example 2: rawurlencode('http://kevin.vanzonneveld.net/');
    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
    // *     example 3: rawurlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
 
    var histogram = {}, unicodeStr='', hexEscStr='';
    var ret = str.toString();

    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };

    // The histogram is identical to the one in urldecode.
    histogram["'"]   = '%27';
    histogram['(']   = '%28';
    histogram[')']   = '%29';
    histogram['*']   = '%2A'; 
    histogram['~']   = '%7E';
    histogram['!']   = '%21';
    histogram['\u20AC'] = '%80';
    histogram['\u0081'] = '%81';
    histogram['\u201A'] = '%82';
    histogram['\u0192'] = '%83';
    histogram['\u201E'] = '%84';
    histogram['\u2026'] = '%85';
    histogram['\u2020'] = '%86';
    histogram['\u2021'] = '%87';
    histogram['\u02C6'] = '%88';
    histogram['\u2030'] = '%89';
    histogram['\u0160'] = '%8A';
    histogram['\u2039'] = '%8B';
    histogram['\u0152'] = '%8C';
    histogram['\u008D'] = '%8D';
    histogram['\u017D'] = '%8E';
    histogram['\u008F'] = '%8F';
    histogram['\u0090'] = '%90';
    histogram['\u2018'] = '%91';
    histogram['\u2019'] = '%92';
    histogram['\u201C'] = '%93';
    histogram['\u201D'] = '%94';
    histogram['\u2022'] = '%95';
    histogram['\u2013'] = '%96';
    histogram['\u2014'] = '%97';
    histogram['\u02DC'] = '%98';
    histogram['\u2122'] = '%99';
    histogram['\u0161'] = '%9A';
    histogram['\u203A'] = '%9B';
    histogram['\u0153'] = '%9C';
    histogram['\u009D'] = '%9D';
    histogram['\u017E'] = '%9E';
    histogram['\u0178'] = '%9F';


    // Begin with encodeURIComponent, which most resembles PHP's encoding functions
    ret = encodeURIComponent(ret);

    for (unicodeStr in histogram) {
        hexEscStr = histogram[unicodeStr];
        ret = replacer(unicodeStr, hexEscStr, ret); // Custom replace. No regexing
    }

    // Uppercase for full PHP compatibility
    return ret.replace(/(\%([a-z0-9]{2}))/g, function(full, m1, m2) {
        return "%"+m2.toUpperCase();
    });
}

function round ( val, precision, mode ) {
    // Returns the number rounded to specified precision  
    // 
    // version: 904.2314
    // discuss at: http://phpjs.org/functions/round
    // +   original by: Philip Peterson
    // +    revised by: Onno Marsman
    // *     example 1: round(1241757, -3);
    // *     returns 1: 1242000
    // *     example 2: round(3.6);
    // *     returns 2: 4
    // Need to support mode flags: PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, or PHP_ROUND_HALF_ODD
 
    return parseFloat(parseFloat(val).toFixed(precision));
}

function serialize( mixed_value ) {
    // Returns a string representation of variable (which can later be unserialized)  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/serialize
    // +   original by: Arpad Ray (mailto:arpad@php.net)
    // +   improved by: Dino
    // +   bugfixed by: Andrej Pavlovic
    // +   bugfixed by: Garagoth
    // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
    // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays
    // *     example 1: serialize(['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}'
    // *     example 2: serialize({firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'});
    // *     returns 2: 'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}'
    var _getType = function( inp ) {
        var type = typeof inp, match;
        var key;
        if (type == 'object' && !inp) {
            return 'null';
        }
        if (type == "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            match = cons.match(/(\w+)\(/);
            if (match) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (key in types) {
                if (cons == types[key]) {
                    type = types[key];
                    break;
                }
            }
        }
        return type;
    };
    var type = _getType(mixed_value);
    var val, ktype = '';
    
    switch (type) {
        case "function": 
            val = ""; 
            break;
        case "undefined":
            val = "N";
            break;
        case "boolean":
            val = "b:" + (mixed_value ? "1" : "0");
            break;
        case "number":
            val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
            break;
        case "string":
            val = "s:" + mixed_value.length + ":\"" + mixed_value + "\"";
            break;
        case "array":
        case "object":
            val = "a";
            /*
            if (type == "object") {
                var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
                if (objname == undefined) {
                    return;
                }
                objname[1] = serialize(objname[1]);
                val = "O" + objname[1].substring(1, objname[1].length - 1);
            }
            */
            var count = 0;
            var vals = "";
            var okey;
            var key;
            for (key in mixed_value) {
                ktype = _getType(mixed_value[key]);
                if (ktype == "function") { 
                    continue; 
                }
                
                okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
                vals += serialize(okey) +
                        serialize(mixed_value[key]);
                count++;
            }
            val += ":" + count + ":{" + vals + "}";
            break;
    }
    if (type != "object" && type != "array") {
	    val += ";";
	}
    return val;
}

function setcookie(name, value, expires, path, domain, secure) {
    // Send a cookie  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/setcookie
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Andreas
    // +   bugfixed by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // -    depends on: setrawcookie
    // *     example 1: setcookie('author_name', 'Kevin van Zonneveld');
    // *     returns 1: true
    return this.setrawcookie(name, encodeURIComponent(value), expires, path, domain, secure);
}

function setrawcookie(name, value, expires, path, domain, secure) {
    // Send a cookie with no url encoding of the value  
    // 
    // version: 905.2214
    // discuss at: http://phpjs.org/functions/setrawcookie
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   derived from: setcookie
    // *     example 1: setcookie('author_name', 'Kevin van Zonneveld');
    // *     returns 1: true
    if (expires instanceof Date) {
        expires = expires.toGMTString();
    } else if(typeof(expires) == 'number') {
        expires = (new Date(+(new Date()) + expires * 1e3)).toGMTString();
    }

    var r = [name + "=" + value], s={}, i='';
    s = {expires: expires, path: path, domain: domain};
    for(i in s){
        s[i] && r.push(i + "=" + s[i]);
    }
    
    return secure && r.push("secure"), this.window.document.cookie = r.join(";"), true;
}

function settype (vr, type) {
   // http://kevin.vanzonneveld.net
    // +   original by: Waldo Malqui Silva
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    revised by: Brett Zamir (http://brettz9.blogspot.com)
    // %        note 1: Credits to Crockford also
    // %        note 2: only works on global variables, and "vr" must be passed in as a string
    // *     example 1: foo = '5bar';
    // *     example 1: settype(foo, 'integer');
    // *     results 1: foo == 5
    // *     returns 1: true
    // *     example 2: foo = true;
    // *     example 2: settype(foo, 'string');
    // *     results 2: foo == '1'
    // *     returns 2: true
    var is_array = function (arr) {
        return typeof arr === 'object' && typeof arr.length === 'number' &&
                    !(arr.propertyIsEnumerable('length')) &&
                    typeof arr.splice === 'function';
    };
    var v, mtch, i, obj;
    v = this[vr] ? this[vr] : vr;
    
    try {
        switch(type) {
            case 'boolean':
                if (is_array(v) && v.length === 0) {this[vr]=false;}
                else if (v === '0') {this[vr]=false;}
                else if (typeof v === 'object' && !is_array(v)) {
                    var lgth = false;
                    for (i in v) {
                        lgth = true;
                    }
                    this[vr]=lgth;
                }
                else {this[vr] = !!v;}
                break;
            case 'integer':
                if (typeof v === 'number') {this[vr]=parseInt(v, 10);}
                else if (typeof v === 'string') {
                    mtch = v.match(/^([+\-]?)(\d+)/);
                    if (!mtch) {this[vr]=0;}
                    else {this[vr]=parseInt(v, 10);}
                }
                else if (v === true) {this[vr]=1;}
                else if (v === false || v === null) {this[vr]=0;}
                else if (is_array(v) && v.length === 0) {this[vr]=0;}
                else if (typeof v === 'object') {this[vr]=1;}

                break;
            case 'float':
                if (typeof v === 'string') {
                    mtch = v.match(/^([+\-]?)(\d+(\.\d+)?|\.\d+)([eE][+\-]?\d+)?/);
                    if (!mtch) {this[vr]=0;}
                    else {this[vr]=parseFloat(v, 10);}
                }
                else if (v === true) {this[vr]=1;}
                else if (v === false || v === null) {this[vr]=0;}
                else if (is_array(v) && v.length === 0) {this[vr]=0;}
                else if (typeof v === 'object') {this[vr]=1;}
                break;
            case 'string':
                if (v === null || v === false) {this[vr]='';}
                else if (is_array(v)) {this[vr]='Array';}
                else if (typeof v === 'object') {this[vr]='Object';}
                else if (v === true) {this[vr]='1';}
                else {this[vr] += '';} // numbers (and functions?)
                break;
            case 'array':
                if (v === null) {this[vr] = [];}
                else if (typeof v !== 'object') {this[vr] = [v];}
                break;
            case 'object':
                if (v === null) {this[vr]={};}
                else if (is_array(v)) {
                    for (i = 0, obj={}; i < v.length; i++) {
                        obj[i] = v;
                    }
                    this[vr] = obj;
                }
                else if (typeof v !== 'object') {this[vr]={scalar:v};}
                break;
            case 'null':
                delete this[vr];
                break;
        }
        return true;
    } catch (e) {
        return false;
    }
}

function sin(arg) {
    // Returns the sine of the number in radians  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/sin
    // +   original by: Onno Marsman
    // *     example 1: sin(8723321.4);
    // *     returns 1: -0.9834330348825909
    return Math.sin(arg);
}

function sinh(arg) {
    // Returns the hyperbolic sine of the number, defined as (exp(number) - exp(-number))/2  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/sinh
    // +   original by: Onno Marsman
    // *     example 1: sinh(-0.9834330348825909);
    // *     returns 1: -1.1497971402636502
    return (Math.exp(arg) - Math.exp(-arg))/2;
}

function sprintf( ) {
    // Return a formatted string  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/sprintf
    // +   original by: Ash Searle (http://hexmen.com/blog/)
    // + namespaced by: Michael White (http://getsprink.com)
    // +    tweaked by: Jack
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Paulo Ricardo F. Santos
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: sprintf("%01.2f", 123.1);
    // *     returns 1: 123.10
    // *     example 2: sprintf("[%10s]", 'monkey');
    // *     returns 2: '[    monkey]'
    // *     example 3: sprintf("[%'#10s]", 'monkey');
    // *     returns 3: '[####monkey]'
    var regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
    var a = arguments, i = 0, format = a[i++];

    // pad()
    var pad = function(str, len, chr, leftJustify) {
        if (!chr) {chr = ' ';}
        var padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
        return leftJustify ? str + padding : padding + str;
    };

    // justify()
    var justify = function(value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
        var diff = minWidth - value.length;
        if (diff > 0) {
            if (leftJustify || !zeroPad) {
                value = pad(value, minWidth, customPadChar, leftJustify);
            } else {
                value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
            }
        }
        return value;
    };

    // formatBaseX()
    var formatBaseX = function(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
        // Note: casts negative numbers to positive ones
        var number = value >>> 0;
        prefix = prefix && number && {'2': '0b', '8': '0', '16': '0x'}[base] || '';
        value = prefix + pad(number.toString(base), precision || 0, '0', false);
        return justify(value, prefix, leftJustify, minWidth, zeroPad);
    };

    // formatString()
    var formatString = function(value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
        if (precision != null) {
            value = value.slice(0, precision);
        }
        return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
    };

    // doFormat()
    var doFormat = function(substring, valueIndex, flags, minWidth, _, precision, type) {
        var number;
        var prefix;
        var method;
        var textTransform;
        var value;

        if (substring == '%%') {return '%';}

        // parse flags
        var leftJustify = false, positivePrefix = '', zeroPad = false, prefixBaseX = false, customPadChar = ' ';
        var flagsl = flags.length;
        for (var j = 0; flags && j < flagsl; j++) {
            switch (flags.charAt(j)) {
                case ' ': positivePrefix = ' '; break;
                case '+': positivePrefix = '+'; break;
                case '-': leftJustify = true; break;
                case "'": customPadChar = flags.charAt(j+1); break;
                case '0': zeroPad = true; break;
                case '#': prefixBaseX = true; break;
            }
        }

        // parameters may be null, undefined, empty-string or real valued
        // we want to ignore null, undefined and empty-string values
        if (!minWidth) {
            minWidth = 0;
        } else if (minWidth == '*') {
            minWidth = +a[i++];
        } else if (minWidth.charAt(0) == '*') {
            minWidth = +a[minWidth.slice(1, -1)];
        } else {
            minWidth = +minWidth;
        }

        // Note: undocumented perl feature:
        if (minWidth < 0) {
            minWidth = -minWidth;
            leftJustify = true;
        }

        if (!isFinite(minWidth)) {
            throw new Error('sprintf: (minimum-)width must be finite');
        }

        if (!precision) {
            precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type == 'd') ? 0 : undefined;
        } else if (precision == '*') {
            precision = +a[i++];
        } else if (precision.charAt(0) == '*') {
            precision = +a[precision.slice(1, -1)];
        } else {
            precision = +precision;
        }

        // grab value using valueIndex if required?
        value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

        switch (type) {
            case 's': return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
            case 'c': return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
            case 'b': return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
            case 'o': return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
            case 'x': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
            case 'X': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
            case 'u': return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
            case 'i':
            case 'd':
                number = parseInt(+value, 10);
                prefix = number < 0 ? '-' : positivePrefix;
                value = prefix + pad(String(Math.abs(number)), precision, '0', false);
                return justify(value, prefix, leftJustify, minWidth, zeroPad);
            case 'e':
            case 'E':
            case 'f':
            case 'F':
            case 'g':
            case 'G':
                number = +value;
                prefix = number < 0 ? '-' : positivePrefix;
                method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
                textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
                value = prefix + Math.abs(number)[method](precision);
                return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
            default: return substring;
        }
    };

    return format.replace(regex, doFormat);
}

function sql_regcase (str) {
	// http://kevin.vanzonneveld.net
	// +   original by: Brett Zamir (http://brettz9.blogspot.com)
	// -    depends on: setlocale
	// *     example 1: sql_regcase('Foo - bar.');
	// *     returns 1: '[Ff][Oo][Oo] - [Bb][Aa][Rr].'

    this.setlocale('LC_ALL', 0);
    var i=0, upper = '', lower='', pos=0, retStr='';

    upper = this.php_js.locales[this.php_js.localeCategories.LC_CTYPE].LC_CTYPE.upper;
    lower = this.php_js.locales[this.php_js.localeCategories.LC_CTYPE].LC_CTYPE.lower;

    for (i=0; i < str.length; i++) {
        if (((pos = upper.indexOf(str.charAt(i))) !== -1) || ((pos = lower.indexOf(str.charAt(i))) !== -1)) {
            retStr += '['+upper[pos]+lower[pos]+']';
        }
        else {
            retStr += str.charAt(i);
        }
    }
    return retStr;
}

function sqrt(arg) {
    // Returns the square root of the number  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/sqrt
    // +   original by: Onno Marsman
    // *     example 1: sqrt(8723321.4);
    // *     returns 1: 2953.5269424875746
    
    return Math.sqrt(arg);
}

function strlen (string) {
    // Get string length  
    // 
    // version: 905.2614
    // discuss at: http://phpjs.org/functions/strlen
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Sakimori
    // +      input by: Kirk Strobeck
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +    revised by: Brett Zamir (http://brettz9.blogspot.com)
    // %        note 1: May look like overkill, but in order to be truly faithful to handling all Unicode
    // %        note 1: characters and to this function in PHP which does not count the number of bytes
    // %        note 1: but counts the number of characters, something like this is really necessary.
    // *     example 1: strlen('Kevin van Zonneveld');
    // *     returns 1: 19
    // *     example 2: strlen('A\ud87e\udc04Z');
    // *     returns 2: 3
    var str = string+'';
    var i = 0, chr = '', lgth = 0;

    var getWholeChar = function (str, i) {
        var code = str.charCodeAt(i);
        var next = '', prev = '';
        if (0xD800 <= code && code <= 0xDBFF) { // High surrogate(could change last hex to 0xDB7F to treat high private surrogates as single characters)
            if (str.length <= (i+1))  {
                throw 'High surrogate without following low surrogate';
            }
            next = str.charCodeAt(i+1);
            if (0xDC00 > next || next > 0xDFFF) {
                throw 'High surrogate without following low surrogate';
            }
            return str.charAt(i)+str.charAt(i+1);
        } else if (0xDC00 <= code && code <= 0xDFFF) { // Low surrogate
            if (i === 0) {
                throw 'Low surrogate without preceding high surrogate';
            }
            prev = str.charCodeAt(i-1);
            if (0xD800 > prev || prev > 0xDBFF) { //(could change last hex to 0xDB7F to treat high private surrogates as single characters)
                throw 'Low surrogate without preceding high surrogate';
            }
            return false; // We can pass over low surrogates now as the second component in a pair which we have already processed
        }
        return str.charAt(i);
    };

    for (i=0, lgth=0; i < str.length; i++) {
        if ((chr = getWholeChar(str, i)) === false) {
            continue;
        } // Adapt this line at the top of any loop, passing in the whole string and the current iteration and returning a variable to represent the individual character; purpose is to treat the first part of a surrogate pair as the whole character and then ignore the second part
        lgth++;
    }
    return lgth;
}

function strrev( string ){
    // Reverse a string  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/strrev
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: strrev('Kevin van Zonneveld');
    // *     returns 1: 'dlevennoZ nav niveK'
    var ret = '', i = 0;

    string += '';
    for ( i = string.length-1; i >= 0; i-- ){
       ret += string.charAt(i);
    }

    return ret;
}

function strripos( haystack, needle, offset){
    // Finds position of last occurrence of a string within another string  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/strripos
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: strripos('Kevin van Zonneveld', 'E');
    // *     returns 1: 16
    var i = (haystack+'').toLowerCase().lastIndexOf( (needle+'').toLowerCase(), offset ); // returns -1
    return i >= 0 ? i : false;
}

function strrpos( haystack, needle, offset){
    // Finds position of last occurrence of a string within another string  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/strrpos
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: strrpos('Kevin van Zonneveld', 'e');
    // *     returns 1: 16
    var i = (haystack+'').lastIndexOf( needle, offset ); // returns -1
    return i >= 0 ? i : false;
}

function strspn(str1, str2, start, lgth){
    // Finds length of initial segment consisting entirely of characters found in mask. If start or/and length is provided works like strspn(substr($s,$start,$len),$good_chars)  
    // 
    // version: 903.3016
    // discuss at: http://phpjs.org/functions/strspn
    // +   original by: Valentina De Rosa
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // *     example 1: strspn('42 is the answer, what is the question ...', '1234567890');
    // *     returns 1: 2
    // *     example 2: strspn('foo', 'o', 1, 2);
    // *     returns 2: 2
    var found;
    var stri;
    var strj;
    var j = 0;
    var i = 0;

    start = start ? (start < 0 ? (str1.length+start) : start) : 0;
    lgth = lgth ? ((lgth < 0) ? (str1.length+lgth-start) : lgth) : str1.length-start;
    str1 = str1.substr(start, lgth);

    for(i = 0; i < str1.length; i++){
        found = 0;
        stri  = str1.substring(i,i+1);
        for (j = 0; j <= str2.length; j++) {
            strj = str2.substring(j,j+1);
            if (stri == strj) {
                found = 1;
                break;
            }
        }
        if (found != 1) {
            return i;
        }
    }

    return i;
}

function strtok (str, tokens) {
    // Tokenize a string  
    // 
    // version: 905.2614
    // discuss at: http://phpjs.org/functions/strtok
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // %        note 1: Use tab and newline as tokenizing characters as well
    // *     example 1: $string = "\t\t\t\nThis is\tan example\nstring\n";
    // *     example 1: $tok = strtok($string, " \n\t");
    // *     example 1: $b = '';
    // *     example 1: while($tok !== false) {$b += "Word="+$tok+"\n"; $tok = strtok(" \n\t");}
    // *     example 1: $b
    // *     returns 1: "Word=This\nWord=is\nWord=an\nWord=example\nWord=string\n"
    if (!this.php_js) {
        this.php_js = {};
    }

    if (tokens === undefined) {
        tokens = str;
        str = this.php_js.strtokleftOver;
    }
    if (str.length === 0) {
        return false;
    }
    if (tokens.indexOf(str.charAt(0)) !== -1) {
        return this.strtok(str.substr(1), tokens);
    }
    for (var i=0; i < str.length; i++) {
        if (tokens.indexOf(str.charAt(i)) !== -1) {
            break;
        }
    }
    this.php_js.strtokleftOver = str.substr(i+1);
    return str.substring(0, i);
}

function strtolower( str ) {
    // Makes a string lowercase  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/strtolower
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Onno Marsman
    // *     example 1: strtolower('Kevin van Zonneveld');
    // *     returns 1: 'kevin van zonneveld'
    return (str+'').toLowerCase();
}

function strtotime(str, now) {
    // Convert string representation of date and time to a timestamp  
    // 
    // version: 905.2617
    // discuss at: http://phpjs.org/functions/strtotime
    // +   original by: Caio Ariede (http://caioariede.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: David
    // +   improved by: Caio Ariede (http://caioariede.com)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Wagner B. Soares
    // %        note 1: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
    // *     example 1: strtotime('+1 day', 1129633200);
    // *     returns 1: 1129719600
    // *     example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
    // *     returns 2: 1130425202
    // *     example 3: strtotime('last month', 1129633200);
    // *     returns 3: 1127041200
    // *     example 4: strtotime('2009-05-04 08:30:00');
    // *     returns 4: 1241418600
    var i, match, s, strTmp = '', parse = '';

    strTmp = str;
    strTmp = strTmp.replace(/\s{2,}|^\s|\s$/g, ' '); // unecessary spaces
    strTmp = strTmp.replace(/[\t\r\n]/g, ''); // unecessary chars

    if (strTmp == 'now') {
        return (new Date()).getTime()/1000; // Return seconds, not milli-seconds
    } else if (!isNaN(parse = Date.parse(strTmp))) {
        return (parse/1000);
    } else if (now) {
        now = new Date(now*1000); // Accept PHP-style seconds
    } else {
        now = new Date();
    }

    strTmp = strTmp.toLowerCase();

    var __is =
    {
        day:
        {
            'sun': 0,
            'mon': 1,
            'tue': 2,
            'wed': 3,
            'thu': 4,
            'fri': 5,
            'sat': 6
        },
        mon:
        {
            'jan': 0,
            'feb': 1,
            'mar': 2,
            'apr': 3,
            'may': 4,
            'jun': 5,
            'jul': 6,
            'aug': 7,
            'sep': 8,
            'oct': 9,
            'nov': 10,
            'dec': 11
        }
    };

    var process = function (m) {
        var ago = (m[2] && m[2] == 'ago');
        var num = (num = m[0] == 'last' ? -1 : 1) * (ago ? -1 : 1);

        switch (m[0]) {
            case 'last':
            case 'next':
                switch (m[1].substring(0, 3)) {
                    case 'yea':
                        now.setFullYear(now.getFullYear() + num);
                        break;
                    case 'mon':
                        now.setMonth(now.getMonth() + num);
                        break;
                    case 'wee':
                        now.setDate(now.getDate() + (num * 7));
                        break;
                    case 'day':
                        now.setDate(now.getDate() + num);
                        break;
                    case 'hou':
                        now.setHours(now.getHours() + num);
                        break;
                    case 'min':
                        now.setMinutes(now.getMinutes() + num);
                        break;
                    case 'sec':
                        now.setSeconds(now.getSeconds() + num);
                        break;
                    default:
                        var day;
                        if (typeof (day = __is.day[m[1].substring(0, 3)]) != 'undefined') {
                            var diff = day - now.getDay();
                            if (diff == 0) {
                                diff = 7 * num;
                            } else if (diff > 0) {
                                if (m[0] == 'last') {diff -= 7;}
                            } else {
                                if (m[0] == 'next') {diff += 7;}
                            }
                            now.setDate(now.getDate() + diff);
                        }
                }
                break;

            default:
                if (/\d+/.test(m[0])) {
                    num *= parseInt(m[0], 10);

                    switch (m[1].substring(0, 3)) {
                        case 'yea':
                            now.setFullYear(now.getFullYear() + num);
                            break;
                        case 'mon':
                            now.setMonth(now.getMonth() + num);
                            break;
                        case 'wee':
                            now.setDate(now.getDate() + (num * 7));
                            break;
                        case 'day':
                            now.setDate(now.getDate() + num);
                            break;
                        case 'hou':
                            now.setHours(now.getHours() + num);
                            break;
                        case 'min':
                            now.setMinutes(now.getMinutes() + num);
                            break;
                        case 'sec':
                            now.setSeconds(now.getSeconds() + num);
                            break;
                    }
                } else {
                    return false;
                }
                break;
        }
        return true;
    };

    match = strTmp.match(/^(\d{2,4}-\d{2}-\d{2})(?:\s(\d{1,2}:\d{2}(:\d{2})?)?(?:\.(\d+))?)?$/);
    if (match != null) {
        if (!match[2]) {
            match[2] = '00:00:00';
        } else if (!match[3]) {
            match[2] += ':00';
        }

        s = match[1].split(/-/g);

        for (i in __is.mon) {
            if (__is.mon[i] == s[1] - 1) {
                s[1] = i;
            }
        }
        s[0] = parseInt(s[0], 10);

        s[0] = (s[0] >= 0 && s[0] <= 69) ? '20'+(s[0] < 10 ? '0'+s[0] : s[0]+'') : (s[0] >= 70 && s[0] <= 99) ? '19'+s[0] : s[0]+'';
        return parseInt(this.strtotime(s[2] + ' ' + s[1] + ' ' + s[0] + ' ' + match[2])+(match[4] ? match[4]/1000 : ''), 10);
    }

    var regex = '([+-]?\\d+\\s'+
        '(years?|months?|weeks?|days?|hours?|min|minutes?|sec|seconds?'+
        '|sun\.?|sunday|mon\.?|monday|tue\.?|tuesday|wed\.?|wednesday'+
        '|thu\.?|thursday|fri\.?|friday|sat\.?|saturday)'+
        '|(last|next)\\s'+
        '(years?|months?|weeks?|days?|hours?|min|minutes?|sec|seconds?'+
        '|sun\.?|sunday|mon\.?|monday|tue\.?|tuesday|wed\.?|wednesday'+
        '|thu\.?|thursday|fri\.?|friday|sat\.?|saturday))'+
        '(\\sago)?';

    match = strTmp.match(new RegExp(regex, 'g'));
    if (match == null) {
        return false;
    }

    for (i in match) {
        if (!process(match[i].split(' '))) {
            return false;
        }
    }

    return (now.getTime()/1000);
}

function strtoupper( str ) {
    // Makes a string uppercase  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/strtoupper
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Onno Marsman
    // *     example 1: strtoupper('Kevin van Zonneveld');
    // *     returns 1: 'KEVIN VAN ZONNEVELD'
    return (str+'').toUpperCase();
}

function substr( f_string, f_start, f_length ) {
    // Returns part of a string  
    // 
    // version: 810.1317
    // discuss at: http://phpjs.org/functions/substr
    // +     original by: Martijn Wieringa
    // +     bugfixed by: T.Wild
    // +      tweaked by: Onno Marsman
    // *       example 1: substr('abcdef', 0, -1);
    // *       returns 1: 'abcde'
    // *       example 2: substr(2, 0, -6);
    // *       returns 2: ''
    f_string += '';

    if(f_start < 0) {
        f_start += f_string.length;
    }

    if(f_length == undefined) {
        f_length = f_string.length;
    } else if(f_length < 0){
        f_length += f_string.length;
    } else {
        f_length += f_start;
    }

    if(f_length < f_start) {
        f_length = f_start;
    }

    return f_string.substring(f_start, f_length);
}

function tan(arg) {
    // Returns the tangent of the number in radians  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/tan
    // +   original by: Onno Marsman
    // *     example 1: tan(8723321.4);
    // *     returns 1: 5.4251848798444815
    return Math.tan(arg);
}

function tanh(arg) {
    // Returns the hyperbolic tangent of the number, defined as sinh(number)/cosh(number)  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/tanh
    // +   original by: Onno Marsman
    // *     example 1: tanh(5.4251848798444815);
    // *     returns 1: 0.9999612058841574
    return (Math.exp(arg) - Math.exp(-arg)) / (Math.exp(arg) + Math.exp(-arg));
}

function time() {
    // Return current UNIX timestamp  
    // 
    // version: 810.114
    // discuss at: http://phpjs.org/functions/time
    // +   original by: GeekFG (http://geekfg.blogspot.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: metjay
    // *     example 1: timeStamp = time();
    // *     results 1: timeStamp > 1000000000 && timeStamp < 2000000000
    
    return Math.round(new Date().getTime()/1000);
}

function trim (str, charlist) {
    // Strips whitespace from the beginning and end of a string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/trim
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: mdsjack (http://www.mdsjack.bo.it)
    // +   improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)
    // +      input by: Erkekjetter
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: DxGx
    // +   improved by: Steven Levithan (http://blog.stevenlevithan.com)
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman
    // *     example 1: trim('    Kevin van Zonneveld    ');
    // *     returns 1: 'Kevin van Zonneveld'
    // *     example 2: trim('Hello World', 'Hdle');
    // *     returns 2: 'o Wor'
    // *     example 3: trim(16, 1);
    // *     returns 3: 6
    var whitespace, l = 0, i = 0;
    str += '';
    
    if (!charlist) {
        // default list
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        // preg_quote custom list
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
    }
    
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }
    
    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

function ucfirst( str ) {
    // Makes a string's first character uppercase  
    // 
    // version: 903.3016
    // discuss at: http://phpjs.org/functions/ucfirst
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // *     example 1: ucfirst('kevin van zonneveld');
    // *     returns 1: 'Kevin van zonneveld'
    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}

function ucwords( str ) {
    // Uppercase the first character of every word in a string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/ucwords
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Waldo Malqui Silva
    // +   bugfixed by: Onno Marsman
    // *     example 1: ucwords('kevin van zonneveld');
    // *     returns 1: 'Kevin Van Zonneveld'
    // *     example 2: ucwords('HELLO WORLD');
    // *     returns 2: 'HELLO WORLD'
    return (str+'').replace(/^(.)|\s(.)/g, function ( $1 ) { return $1.toUpperCase( ); } );
}

function unserialize(data){
    // Takes a string representation of variable and recreates it
    //
    // version: 903.3016
    // discuss at: http://phpjs.org/functions/unserialize
    // +     original by: Arpad Ray (mailto:arpad@php.net)
    // +     improved by: Pedro Tainha (http://www.pedrotainha.com)
    // +     bugfixed by: dptr1988
    // +      revised by: d3x
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // %            note: We feel the main purpose of this function should be to ease the transport of data between php & js
    // %            note: Aiming for PHP-compatibility, we have to translate objects to arrays
    // *       example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
    // *       returns 1: ['Kevin', 'van', 'Zonneveld']
    // *       example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
    // *       returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}
    var error = function (type, msg, filename, line){throw new this.window[type](msg, filename, line);};
    var read_until = function (data, offset, stopchr){
        var buf = [];
        var chr = data.slice(offset, offset + 1);
        var i = 2;
        while (chr != stopchr) {
            if ((i+offset) > data.length) {
                error('Error', 'Invalid');
            }
            buf.push(chr);
            chr = data.slice(offset + (i - 1),offset + i);
            i += 1;
        }
        return [buf.length, buf.join('')];
    };
    var read_chrs = function (data, offset, length){
        var buf;

        buf = [];
        for(var i = 0;i < length;i++){
            var chr = data.slice(offset + (i - 1),offset + i);
            buf.push(chr);
        }
        return [buf.length, buf.join('')];
    };
    var _unserialize = function (data, offset){
        var readdata;
        var readData;
        var chrs = 0;
        var ccount;
        var stringlength;
        var keyandchrs;
        var keys;

        if(!offset) {offset = 0;}
        var dtype = (data.slice(offset, offset + 1)).toLowerCase();

        var dataoffset = offset + 2;
        var typeconvert = new Function('x', 'return x');

        switch(dtype){
            case 'i':
                typeconvert = function (x) {return parseInt(x, 10);};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'b':
                typeconvert = function (x) {return parseInt(x, 10) == 1;};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'd':
                typeconvert = function (x) {return parseFloat(x);};
                readData = read_until(data, dataoffset, ';');
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 1;
            break;
            case 'n':
                readdata = null;
            break;
            case 's':
                ccount = read_until(data, dataoffset, ':');
                chrs = ccount[0];
                stringlength = ccount[1];
                dataoffset += chrs + 2;

                readData = read_chrs(data, dataoffset+1, parseInt(stringlength, 10));
                chrs = readData[0];
                readdata = readData[1];
                dataoffset += chrs + 2;
                if(chrs != parseInt(stringlength, 10) && chrs != readdata.length){
                    error('SyntaxError', 'String length mismatch');
                }
            break;
            case 'a':
                readdata = {};

                keyandchrs = read_until(data, dataoffset, ':');
                chrs = keyandchrs[0];
                keys = keyandchrs[1];
                dataoffset += chrs + 2;

                for(var i = 0;i < parseInt(keys, 10);i++){
                    var kprops = _unserialize(data, dataoffset);
                    var kchrs = kprops[1];
                    var key = kprops[2];
                    dataoffset += kchrs;

                    var vprops = _unserialize(data, dataoffset);
                    var vchrs = vprops[1];
                    var value = vprops[2];
                    dataoffset += vchrs;

                    readdata[key] = value;
                }

                dataoffset += 1;
            break;
            default:
                error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
            break;
        }
        return [dtype, dataoffset - offset, typeconvert(readdata)];
    };
    return _unserialize(data, 0)[2];
}

function urldecode( str ) {
    // Decodes URL-encoded string  
    // 
    // version: 905.412
    // discuss at: http://phpjs.org/functions/urldecode
    // +   original by: Philip Peterson
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: AJ
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Lars Fischer
    // %          note 1: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
    // *     example 1: urldecode('Kevin+van+Zonneveld%21');
    // *     returns 1: 'Kevin van Zonneveld!'
    // *     example 2: urldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
    // *     returns 2: 'http://kevin.vanzonneveld.net/'
    // *     example 3: urldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
    // *     returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'
    
    var histogram = {}, ret = str.toString(), unicodeStr='', hexEscStr='';
    
    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };
    
    // The histogram is identical to the one in urlencode.
    histogram["'"]   = '%27';
    histogram['(']   = '%28';
    histogram[')']   = '%29';
    histogram['*']   = '%2A';
    histogram['~']   = '%7E';
    histogram['!']   = '%21';
    histogram['%20'] = '+';
    histogram['\u00DC'] = '%DC';
    histogram['\u00FC'] = '%FC';
    histogram['\u00C4'] = '%D4';
    histogram['\u00E4'] = '%E4';
    histogram['\u00D6'] = '%D6';
    histogram['\u00F6'] = '%F6';
    histogram['\u00DF'] = '%DF'; 
    histogram['\u20AC'] = '%80';
    histogram['\u0081'] = '%81';
    histogram['\u201A'] = '%82';
    histogram['\u0192'] = '%83';
    histogram['\u201E'] = '%84';
    histogram['\u2026'] = '%85';
    histogram['\u2020'] = '%86';
    histogram['\u2021'] = '%87';
    histogram['\u02C6'] = '%88';
    histogram['\u2030'] = '%89';
    histogram['\u0160'] = '%8A';
    histogram['\u2039'] = '%8B';
    histogram['\u0152'] = '%8C';
    histogram['\u008D'] = '%8D';
    histogram['\u017D'] = '%8E';
    histogram['\u008F'] = '%8F';
    histogram['\u0090'] = '%90';
    histogram['\u2018'] = '%91';
    histogram['\u2019'] = '%92';
    histogram['\u201C'] = '%93';
    histogram['\u201D'] = '%94';
    histogram['\u2022'] = '%95';
    histogram['\u2013'] = '%96';
    histogram['\u2014'] = '%97';
    histogram['\u02DC'] = '%98';
    histogram['\u2122'] = '%99';
    histogram['\u0161'] = '%9A';
    histogram['\u203A'] = '%9B';
    histogram['\u0153'] = '%9C';
    histogram['\u009D'] = '%9D';
    histogram['\u017E'] = '%9E';
    histogram['\u0178'] = '%9F';

    for (unicodeStr in histogram) {
        hexEscStr = histogram[unicodeStr]; // Switch order when decoding
        ret = replacer(hexEscStr, unicodeStr, ret); // Custom replace. No regexing
    }
    
    // End with decodeURIComponent, which most resembles PHP's encoding functions
    ret = decodeURIComponent(ret);

    return ret;
}

function urlencode( str ) {
    // URL-encodes string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/urlencode
    // +   original by: Philip Peterson
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: AJ
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: travc
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Lars Fischer
    // %          note 1: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
    // *     example 1: urlencode('Kevin van Zonneveld!');
    // *     returns 1: 'Kevin+van+Zonneveld%21'
    // *     example 2: urlencode('http://kevin.vanzonneveld.net/');
    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
    // *     example 3: urlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
                             
    var histogram = {}, unicodeStr='', hexEscStr='';
    var ret = (str+'').toString();
    
    var replacer = function(search, replace, str) {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };
    
    // The histogram is identical to the one in urldecode.
    histogram["'"]   = '%27';
    histogram['(']   = '%28';
    histogram[')']   = '%29';
    histogram['*']   = '%2A';
    histogram['~']   = '%7E';
    histogram['!']   = '%21';
    histogram['%20'] = '+';
    histogram['\u00DC'] = '%DC';
    histogram['\u00FC'] = '%FC';
    histogram['\u00C4'] = '%D4';
    histogram['\u00E4'] = '%E4';
    histogram['\u00D6'] = '%D6';
    histogram['\u00F6'] = '%F6';
    histogram['\u00DF'] = '%DF';
    histogram['\u20AC'] = '%80';
    histogram['\u0081'] = '%81';
    histogram['\u201A'] = '%82';
    histogram['\u0192'] = '%83';
    histogram['\u201E'] = '%84';
    histogram['\u2026'] = '%85';
    histogram['\u2020'] = '%86';
    histogram['\u2021'] = '%87';
    histogram['\u02C6'] = '%88';
    histogram['\u2030'] = '%89';
    histogram['\u0160'] = '%8A';
    histogram['\u2039'] = '%8B';
    histogram['\u0152'] = '%8C';
    histogram['\u008D'] = '%8D';
    histogram['\u017D'] = '%8E';
    histogram['\u008F'] = '%8F';
    histogram['\u0090'] = '%90';
    histogram['\u2018'] = '%91';
    histogram['\u2019'] = '%92';
    histogram['\u201C'] = '%93';
    histogram['\u201D'] = '%94';
    histogram['\u2022'] = '%95';
    histogram['\u2013'] = '%96';
    histogram['\u2014'] = '%97';
    histogram['\u02DC'] = '%98';
    histogram['\u2122'] = '%99';
    histogram['\u0161'] = '%9A';
    histogram['\u203A'] = '%9B';
    histogram['\u0153'] = '%9C';
    histogram['\u009D'] = '%9D';
    histogram['\u017E'] = '%9E';
    histogram['\u0178'] = '%9F';
    
    // Begin with encodeURIComponent, which most resembles PHP's encoding functions
    ret = encodeURIComponent(ret);

    for (unicodeStr in histogram) {
        hexEscStr = histogram[unicodeStr];
        ret = replacer(unicodeStr, hexEscStr, ret); // Custom replace. No regexing
    }
    
    // Uppercase for full PHP compatibility
    return ret.replace(/(\%([a-z0-9]{2}))/g, function(full, m1, m2) {
        return "%"+m2.toUpperCase();
    });
}

function utf8_decode ( str_data ) {
    // Converts a UTF-8 encoded string to ISO-8859-1  
    // 
    // version: 903.3016
    // discuss at: http://phpjs.org/functions/utf8_decode
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork
    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brettz9.blogspot.com)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
    var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0;
    
    str_data += '';
    
    while ( i < str_data.length ) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if ((c1 > 191) && (c1 < 224)) {
            c2 = str_data.charCodeAt(i+1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i+1);
            c3 = str_data.charCodeAt(i+2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }

    return tmp_arr.join('');
}

function utf8_encode ( argString ) {
    // Encodes an ISO-8859-1 string to UTF-8  
    // 
    // version: 905.1217
    // discuss at: http://phpjs.org/functions/utf8_encode
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: sowberry
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman
    // +   improved by: Yves Sucaet
    // +   bugfixed by: Onno Marsman
    // *     example 1: utf8_encode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'
    var string = (argString+'').replace(/\r\n/g, "\n").replace(/\r/g, "\n");

    var utftext = "";
    var start, end;
    var stringl = 0;

    start = end = 0;
    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;

        if (c1 < 128) {
            end++;
        } else if((c1 > 127) && (c1 < 2048)) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {
            enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.substring(start, end);
            }
            utftext += enc;
            start = end = n+1;
        }
    }

    if (end > start) {
        utftext += string.substring(start, string.length);
    }

    return utftext;
}

function var_dump() {
    // Dumps a string representation of variable to output  
    // 
    // version: 905.2214
    // discuss at: http://phpjs.org/functions/var_dump
    // +   original by: Brett Zamir (http://brettz9.blogspot.com)
    // -    depends on: echo
    // *     example 1: var_dump(1);
    // *     returns 1: 'int(1)'

    var output = "", pad_char = " ", pad_val = 4, lgth = 0, i = 0, d = this.window.document;

    var repeat_char = function (len, pad_char) {
        var str = "";
        for(var i=0; i < len; i++) {
            str += pad_char;
        }
        return str;
    };
    var getScalarVal = function (val) {
        var ret = '';
        if (val === null) {
            ret = 'NULL';
        }
        else if (typeof val === 'boolean') {
            ret = 'bool('+val+')';
        }
        else if (typeof val === 'string') {
            ret = 'string('+val.length+') "'+val+'"';
        }
        else if (typeof val === 'number') {
            if (parseFloat(val) == parseInt(val, 10)) {
                ret = 'int('+val+')';
            }
            else {
                ret = 'float('+val+')';
            }
        }
        else if (val === undefined) {
            ret = 'UNDEFINED'; // Not PHP behavior, but neither is undefined as value
        }
        else if (typeof val === 'function') {
            ret = 'FUNCTION'; // Not PHP behavior, but neither is function as value
        }
        return ret;
    };

    var formatArray = function (obj, cur_depth, pad_val, pad_char) {
        var someProp = '';
        if (cur_depth > 0) {
            cur_depth++;
        }

        var base_pad = repeat_char(pad_val*(cur_depth-1), pad_char);
        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
        var str = "";
        var val='';

        if (typeof obj === 'object' && obj !== null) {
            if (obj.constructor && obj.constructor.name === 'PHPJS_Resource') {
                return obj.var_dump();
            }
            lgth = 0;
            for (someProp in obj) {
                lgth++;
            }
            str += "array("+lgth+") {\n";
            for (var key in obj) {
                if (typeof obj[key] === 'object' && obj[key] !== null) {
                    str += thick_pad + "["+key+"] =>\n"+thick_pad+formatArray(obj[key], cur_depth+1, pad_val, pad_char);
                } else {
                    val = getScalarVal(obj[key]);
                    str += thick_pad + "["+key+"] =>\n"+thick_pad + val + "\n";
                }
            }
            str += base_pad + "}\n";
        } else {
            str = getScalarVal(obj);
        }
        return str;
    };

    output = formatArray(arguments[0], 0, pad_val, pad_char);
    for (i=1; i < arguments.length; i++) {
        output += '\n'+formatArray(arguments[i], 0, pad_val, pad_char);
    }

    if (d.body) {
        this.echo(output);
    }
    else {
        try {
            d = XULDocument; // We're in XUL, so appending as plain text won't work
            this.echo('<pre xmlns="http://www.w3.org/1999/xhtml" style="white-space:pre;">'+output+'</pre>');
        }
        catch(e) {
            this.echo(output); // Outputting as plain text may work in some plain XML
        }
    }
}

function var_export(mixed_expression, bool_return) {
        // Outputs or returns a string representation of a variable
        //
        // version: 904.610
        // discuss at: http://phpjs.org/functions/var_export
        // +   original by: Philip Peterson
        // +   improved by: johnrembo
        // +   improved by: Brett Zamir (http://brettz9.blogspot.com)
        // -    depends on: echo
        // *     example 1: var_export(null);
        // *     returns 1: null
        // *     example 2: var_export({0: 'Kevin', 1: 'van', 2: 'Zonneveld'}, true);
        // *     returns 2: "array (\n  0 => 'Kevin',\n  1 => 'van',\n  2 => 'Zonneveld'\n)"
        // *     example 3: data = 'Kevin';
        // *     example 3: var_export(data, true);
        // *     returns 3: "'Kevin'"
        var retstr = "";
        var iret = "";
        var cnt = 0;
        var x = [];
        var i = 0;

        var __getType = function( inp ) {
            var i = 0;
            var match, type = typeof inp;
            if (type == 'object' && inp.constructor && inp.constructor.name === 'PHPJS_Resource') {
                return 'resource';
            }
            if (type == 'object' && !inp) {
                return 'null'; // Should this be just null?
            }
            if (type == "object") {
                if (!inp.constructor) {
                    return 'object';
                }
                var cons = inp.constructor.toString();
                match = cons.match(/(\w+)\(/);
                if (match) {
                    cons = match[1].toLowerCase();
                }
                var types = ["boolean", "number", "string", "array"];
                for (i=0; i < types.length; i++) {
                    if (cons == types[i]) {
                        type = types[i];
                        break;
                    }
                }
            }
            return type;
        };
        var type = __getType(mixed_expression);

        if( type === null) {
            retstr = "NULL";
        } else if(type == 'array' || type == 'object') {
            for(i in mixed_expression) {
                x[cnt++] = this.var_export(i,true)+" => "+this.var_export(mixed_expression[i], true);
            }
            iret = x.join(',\n  ');
            retstr = "array (\n  "+iret+"\n)";
        }
        else if (type === 'resource') {
            retstr = 'NULL'; // Resources treated as null for var_export
        } else {
            retstr = (!isNaN( mixed_expression )) ? mixed_expression : "'" + mixed_expression.replace(/(["'])/g, "\\$1").replace(/\0/g, "\\0") + "'";
        }

        if(bool_return !== true) {
            this.echo(retstr);
            return null;
        } else {
            return retstr;
        }
    }

function vprintf(format, args) {
    // Output a formatted string  
    // 
    // version: 905.2214
    // discuss at: http://phpjs.org/functions/vprintf
    // +   original by: Ash Searle (http://hexmen.com/blog/)
    // +   improved by: Michael White (http://getsprink.com)
    // + reimplemented by: Brett Zamir (http://brettz9.blogspot.com)
    // -    depends on: sprintf
    // *     example 1: printf("%01.2f", 123.1);
    // *     returns 1: 6
    var body, elmt;
    var ret = '', d = this.window.document;

    // .shift() does not work to get first item in bodies

    var HTMLNS = 'http://www.w3.org/1999/xhtml';
    body = d.getElementsByTagNameNS ?
      (d.getElementsByTagNameNS(HTMLNS, 'body')[0] ?
        d.getElementsByTagNameNS(HTMLNS, 'body')[0] :
        d.documentElement.lastChild) :
      d.getElementsByTagName('body')[0];

    if (!body) {
        return false;
    }

    ret = this.sprintf.apply(this, [format].concat(args));

    elmt = d.createTextNode(ret);
    body.appendChild(elmt);

    return ret.length;
}

function vsprintf(format, args) {
    // Return a formatted string  
    // 
    // version: 905.1001
    // discuss at: http://phpjs.org/functions/vsprintf
    // +   original by: ejsanders
    // -    depends on: sprintf
    // *     example 1: vsprintf('%04d-%02d-%02d', [1988, 8, 1]);
    // *     returns 1: '1988-08-01'
    return this.sprintf.apply(this, [format].concat(args));
}

function wordwrap( str, int_width, str_break, cut ) {
    // Wraps buffer to selected number of characters using string break char  
    // 
    // version: 904.1923
    // discuss at: http://phpjs.org/functions/wordwrap
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Nick Callen
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Sakimori
    // +   bugfixed by: Michael Grier
    // *     example 1: wordwrap('Kevin van Zonneveld', 6, '|', true);
    // *     returns 1: 'Kevin |van |Zonnev|eld'
    // *     example 2: wordwrap('The quick brown fox jumped over the lazy dog.', 20, '<br />\n');
    // *     returns 2: 'The quick brown fox <br />\njumped over the lazy<br />\n dog.'
    // *     example 3: wordwrap('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
    // *     returns 3: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod \ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim \nveniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \ncommodo consequat.'
    // PHP Defaults
    var m = ((arguments.length >= 2) ? arguments[1] : 75   );
    var b = ((arguments.length >= 3) ? arguments[2] : "\n" );
    var c = ((arguments.length >= 4) ? arguments[3] : false);

    var i, j, l, s, r;

    str += '';

    if (m < 1) {
        return str;
    }

    for (i = -1, l = (r = str.split(/\r\n|\n|\r/)).length; ++i < l; r[i] += s) {
        for(s = r[i], r[i] = ""; s.length > m; r[i] += s.slice(0, j) + ((s = s.slice(j)).length ? b : "")){
            j = c == 2 || (j = s.slice(0, m + 1).match(/\S*(\s)?$/))[1] ? m : j.input.length - j[0].length || c == 1 && m || j.input.length + (j = s.slice(m).match(/^\S*/)).input.length;
        }
    }
    
    return r.join("\n");
}
