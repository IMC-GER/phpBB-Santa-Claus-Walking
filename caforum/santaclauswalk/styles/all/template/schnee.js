/**
 * Copyright (C) 2008 by Fabian Schlieper
 * Copyright (C) 2026 by Thorsten Ahlers
 * Customized for phpBB with Santa Claus Walking and the IMC-Prosilver Style
 * Schnee v1.2.0-pl1
 * http://www.fabi.me/
 * Ohne dieses Copyright darf dieser Code nicht verwendet werden!
 */

// die ID des HTML-Elements, in dem es schneien soll
const snowAreaId = 'snowfalling';

// maximale Anzahl der sichtbaren Schneeflocken
const snowFlakeCount = 200;

// die verschiedenen Farbe, die die Schneeflocken haben sollen
const snowColours = ['#FAFAD9','#AAAACC','#DDDDFF','#ECF1F3','#F3F3F3','#B3CEF5'];

// die Schriftarten, aus denen die Schneeflocken bestehen sollen
const snowFonts = ['Lucida Grande', 'Helvetica', 'Arial Black', 'Arial Narrow', 'Monospace', 'Verdana', 'Times', 'Comic Sans MS'];

const snowChar    = '*';	// das Zeichen, das als Schneeflocke verwendet wird
const snowGravity = 0.6;	// wie schnell die Schneeflocken fallen
const snowSizeMax = 18;		// die maximale Schriftgröße einer Schneeflocke
const snowSizeMin = 11;		// die minimale Schriftgröße einer Schneeflocke

// ########################################################################################
// HIER ENDET DIE KONFIGURATION. ÄNDERUNGEN IM FOLGENDEN SETZEN JAVSCRIPT-KENNTNISSE VORAUS
// ########################################################################################

const snowInitTime   = 0;
var	  snowFlakes	 = [];
const snowArea		 = document.getElementById(snowAreaId);
const snowAreaHeight = 300;		// snowArea.offsetHeight;
const snowAreaWidth  = 1280;	// snowArea.offsetWidth;
var	  snowInterval   = 0;
const IMCGER_STORAGE_KEY = 'imcger_' + snowAreaId;

function snowAreaWriteStorage() {
	let data = [];

	snowFlakes.forEach((snowFlake, i) => {
		data[i] = [
			snowFlake.style.cssText,
			snowFlake.posx,
			snowFlake.posy,
			snowFlake.sink,
			snowFlake.wobamp,
			snowFlake.wob
		];
	});

	window.sessionStorage.setItem(IMCGER_STORAGE_KEY, JSON.stringify(data));
}

function snowAreaReadStorage() {
	try {
		let data = JSON.parse(window.sessionStorage.getItem(IMCGER_STORAGE_KEY));

		if (typeof(data) === 'object') {
			data.forEach((flake, i) => {
				snowFlakes[i].style.cssText = flake[0];
				snowFlakes[i].posx			= flake[1];
				snowFlakes[i].posy			= flake[2];
				snowFlakes[i].sink			= flake[3];
				snowFlakes[i].wobamp		= flake[4];
				snowFlakes[i].wob			= flake[5];
			});
		}
	} catch (e) {}
}

function snowAreaCreateSnowflakes()
{
	let fragment = document.createDocumentFragment();

	for (let i = 0; i <= snowFlakeCount; i++) {
		const span = document.createElement('span');

		span.id			   = 'snwflk' + i;
		span.textContent   = snowChar;
		span.style.cssText = 'position: absolute; top: -' + snowSizeMax + 'px; z-index: ' + (9 + (i % 2 * 2)).toString() + ';';

		fragment.appendChild(span);
	}

	snowArea.appendChild(fragment);
}

function snowAreaRandInt(range) {
	return Math.floor(Math.random() * range);
}

function snowAreaInitSnow() {
	// Reapeat until we have the snowArea
	if (!snowArea || snowAreaWidth <= snowSizeMax || snowAreaHeight <= snowSizeMax) {
		// After 5 secs cancel
		if (snowInitTime < 5000) {
			window.setTimeout(snowAreaInitSnow, 50);
		}

		snowInitTime += 50;
		return;
	}

	// offset fix
	snowArea.style.position = 'relative';

	for (let i = 0; i <= snowFlakeCount; i++) {
		snowFlakes[i] = document.getElementById('snwflk' + i);

		snowFlakes[i].size	 = (snowAreaRandInt(snowSizeMax - snowSizeMin) + snowSizeMin);
		snowFlakes[i].posx	 = -snowFlakes[i].size;
		snowFlakes[i].posy	 = -snowFlakes[i].size;
		snowFlakes[i].sink	 = (snowGravity * snowFlakes[i].size / snowSizeMin);
		snowFlakes[i].wobamp = (Math.random() * (snowFlakes[i].size));
		snowFlakes[i].wob	 = 0.0;
		snowFlakes[i].wobspeed = (0.03 + Math.random() / 10.0);

		snowFlakes[i].style.fontFamily = snowFonts[snowAreaRandInt(snowFonts.length)];
		snowFlakes[i].style.fontSize   = snowFlakes[i].size + 'px';
		snowFlakes[i].style.color	   = snowColours[snowAreaRandInt(snowColours.length)];
	}

	if (!snowInterval) {
		snowAreaReadStorage();	// Read data and restore the snow flakes
		snowInterval = window.setInterval(snowAreaUpdateSnow, 50);
	}
}

function snowAreaUpdateSnow() {
	let bl = snowArea.offsetLeft;
	let bt = snowArea.offsetTop;
	let bw = snowAreaWidth;
	let bh = snowAreaHeight;
	let br = bl + bw;
	let bb = bt + bh;

	snowFlakes.forEach((snowFlake) => {
		snowFlake.wob += snowFlake.wobspeed;
		let x = snowFlake.posx + (snowFlake.wobamp * Math.sin(snowFlake.wob));
		snowFlake.posy += snowFlake.sink;

		snowFlake.style.left = Math.round(x) + 'px';
		snowFlake.style.top = Math.round(snowFlake.posy) + 'px';

		let s = snowFlake.size;
		// check bounds
		if (snowFlake.posy > (bb - s) || x < bl || x  > (br - s)) {
			snowFlake.posx = bl + s + snowAreaRandInt(bw - (3 * s));

			if (snowFlake.posy < 0)
				snowFlake.posy = bt + snowAreaRandInt(bh - 2 * s);
			else
				snowFlake.posy = bt;
		}
	});
}

// Store snow flake data when website changed
window.addEventListener('pagehide', snowAreaWriteStorage);
document.addEventListener('visibilitychange', function () {
	if (document.visibilityState === 'hidden') {
		snowAreaWriteStorage();
	}
});

// Schnee initialisieren
snowAreaCreateSnowflakes();
snowAreaInitSnow();
