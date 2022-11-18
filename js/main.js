"use strict";

/**
 * DataTable Settings
 */
$(document).ready(function () {
	$('#adminEditUserTable').DataTable({
		scrollX: true,
		columnDefs: [{
			targets: 'no-sort',
			orderable: false,
		}]
	});
	$('#adminEditCampaignTable, #adminEditCampaignTable2').DataTable({
		scrollX: true,
		columnDefs: [{
			targets: 'no-sort',
			orderable: false,
		}]
	});
	$('#donationHistory, #acceptedDonationHistory').DataTable({
		scrollX: true,
		columnDefs: [{
			targets: 'no-sort',
			orderable: false,
		}]
	});
});

/**
 * Toggle password visibility
 */
$('input[data-toggle="password"]').each(function () {
	var input = $(this);
	var eye_btn = $(this).parent().find(".input-group-text");
	eye_btn.css("cursor", "pointer").addClass("input-password-hide");
	eye_btn.on("click", function () {
		if (eye_btn.hasClass("input-password-hide")) {
			eye_btn
				.removeClass("input-password-hide")
				.addClass("input-password-show");
			eye_btn
				.find(".bi")
				.removeClass("bi-eye-fill")
				.addClass("bi-eye-slash-fill");
			input.attr("type", "text");
		} else {
			eye_btn
				.removeClass("input-password-show")
				.addClass("input-password-hide");
			eye_btn
				.find(".bi")
				.removeClass("bi-eye-slash-fill")
				.addClass("bi-eye-fill");
			input.attr("type", "password");
		}
	});
});

/**
 * Check if new password and confirm new password are the same
 */
Array.from(document.querySelectorAll("#newPassword, #confirmNewPassword")
).forEach((e) =>
	e.addEventListener("keyup", function () {
		var newPassword = document.querySelector("#newPassword").value;
		var confirmNewPassword = document.querySelector("#confirmNewPassword").value;
		var checkSamePasswordMessage = document.querySelector("#checkSamePasswordMessage");
		if (newPassword != "" && confirmNewPassword != "") {
			if (newPassword == confirmNewPassword) {
				checkSamePasswordMessage.innerHTML = '<div class="alert alert-success" role="alert">New passsword matching</div>';
			} else {
				checkSamePasswordMessage.innerHTML = '<div class="alert alert-danger" role="alert">New passsword not matching</div>';
			}
		} else {
			checkSamePasswordMessage.innerHTML = "";
		}
	})
);

/**
 * Easy selector helper function
 */
const select = (el, all = false) => {
	el = el.trim();
	if (all) {
		return [...document.querySelectorAll(el)];
	} else {
		return document.querySelector(el);
	}
};

/**
 * Easy event listener function
 */
const on = (type, el, listener, all = false) => {
	if (all) {
		select(el, all).forEach((e) => e.addEventListener(type, listener));
	} else {
		select(el, all).addEventListener(type, listener);
	}
};

/**
 * Easy on scroll event listener
 */
const onscroll = (el, listener) => {
	el.addEventListener("scroll", listener);
};

/**
 * Sidebar toggle
 */
if (select(".toggle-sidebar-btn")) {
	on("click", ".toggle-sidebar-btn", function (e) {
		select("body").classList.toggle("toggle-sidebar");
	});
}

/**
 * Search bar toggle
 */
if (select(".search-bar-toggle")) {
	on("click", ".search-bar-toggle", function (e) {
		select(".search-bar").classList.toggle("search-bar-show");
	});
}

/**
 * Navbar links active state on scroll
 */
let navbarlinks = select("#navbar .scrollto", true);
const navbarlinksActive = () => {
	let position = window.scrollY + 200;
	navbarlinks.forEach((navbarlink) => {
		if (!navbarlink.hash) return;
		let section = select(navbarlink.hash);
		if (!section) return;
		if (
			position >= section.offsetTop &&
			position <= section.offsetTop + section.offsetHeight
		) {
			navbarlink.classList.add("active");
		} else {
			navbarlink.classList.remove("active");
		}
	});
};
window.addEventListener("load", navbarlinksActive);
onscroll(document, navbarlinksActive);

/**
 * Toggle .header-scrolled class to #header when page is scrolled
 */
let selectHeader = select("#header");
if (selectHeader) {
	const headerScrolled = () => {
		if (window.scrollY > 100) {
			selectHeader.classList.add("header-scrolled");
		} else {
			selectHeader.classList.remove("header-scrolled");
		}
	};
	window.addEventListener("load", headerScrolled);
	onscroll(document, headerScrolled);
}

/**
 * Back to top button
 */
let backtotop = select(".back-to-top");
if (backtotop) {
	const toggleBacktotop = () => {
		if (window.scrollY > 100) {
			backtotop.classList.add("active");
		} else {
			backtotop.classList.remove("active");
		}
	};
	window.addEventListener("load", toggleBacktotop);
	onscroll(document, toggleBacktotop);
}

/**
 * Initiate tooltips
 */
var tooltipTriggerList = [].slice.call(
	document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl);
});

/**
  * Initiate TinyMCE Editor
  */

var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

tinymce.init({
	selector: 'textarea.tinymce-editor',
	plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
	imagetools_cors_hosts: ['picsum.photos'],
	menubar: 'file edit view insert format tools table help',
	toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
	toolbar_sticky: true,
	autosave_ask_before_unload: true,
	autosave_interval: '30s',
	autosave_prefix: '{path}{query}-{id}-',
	autosave_restore_when_empty: false,
	autosave_retention: '2m',
	image_advtab: true,
	link_list: [{
		title: 'My page 1',
		value: 'https://www.tiny.cloud'
	},
	{
		title: 'My page 2',
		value: 'http://www.moxiecode.com'
	}
	],
	image_list: [{
		title: 'My page 1',
		value: 'https://www.tiny.cloud'
	},
	{
		title: 'My page 2',
		value: 'http://www.moxiecode.com'
	}
	],
	image_class_list: [{
		title: 'None',
		value: ''
	},
	{
		title: 'Some class',
		value: 'class-name'
	}
	],
	importcss_append: true,
	file_picker_callback: function (callback, value, meta) {
		/* Provide file and text for the link dialog */
		if (meta.filetype === 'file') {
			callback('https://www.google.com/logos/google.jpg', {
				text: 'My text'
			});
		}

		/* Provide image and alt text for the image dialog */
		if (meta.filetype === 'image') {
			callback('https://www.google.com/logos/google.jpg', {
				alt: 'My alt text'
			});
		}

		/* Provide alternative source and posted for the media dialog */
		if (meta.filetype === 'media') {
			callback('movie.mp4', {
				source2: 'alt.ogg',
				poster: 'https://www.google.com/logos/google.jpg'
			});
		}
	},
	templates: [{
		title: 'New Table',
		description: 'creates a new table',
		content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
	},
	{
		title: 'Starting my story',
		description: 'A cure for writers block',
		content: 'Once upon a time...'
	},
	{
		title: 'New list with dates',
		description: 'New List with dates',
		content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
	}
	],
	template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
	template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
	height: 600,
	image_caption: true,
	quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
	noneditable_noneditable_class: 'mceNonEditable',
	toolbar_mode: 'sliding',
	contextmenu: 'link image imagetools table',
	skin: useDarkMode ? 'oxide-dark' : 'oxide',
	content_css: useDarkMode ? 'dark' : 'default',
	content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

/**
 * Initiate quill editors
 */
if (select(".quill-editor-default")) {
	new Quill(".quill-editor-default", {
		theme: "snow",
	});
}

if (select(".quill-editor-bubble")) {
	new Quill(".quill-editor-bubble", {
		theme: "bubble",
	});
}

if (select(".quill-editor-full")) {
	new Quill(".quill-editor-full", {
		modules: {
			toolbar: [
				[
					{
						font: [],
					},
					{
						size: [],
					},
				],
				["bold", "italic", "underline", "strike"],
				[
					{
						color: [],
					},
					{
						background: [],
					},
				],
				[
					{
						script: "super",
					},
					{
						script: "sub",
					},
				],
				[
					{
						list: "ordered",
					},
					{
						list: "bullet",
					},
					{
						indent: "-1",
					},
					{
						indent: "+1",
					},
				],
				[
					"direction",
					{
						align: [],
					},
				],
				["link", "image", "video"],
				["clean"],
			],
		},
		theme: "snow",
	});
}

/*************** Validation ***************/
/**
 * Initiate Bootstrap validation check
 */
// const forms = document.querySelectorAll(".needs-validation");
// Array.prototype.slice.call(forms).forEach((form) => {
//     form.addEventListener(
//         "submit",
//         (event) => {
//             if (!form.checkValidity()) {
//                 event.preventDefault();
//                 event.stopPropagation();
//             }
//             form.classList.add("was-validated");
//         },
//         false
//     );
// });

var needsValidation = document.querySelectorAll(".needs-validation");
Array.prototype.slice.call(needsValidation).forEach(function (form) {
	form.addEventListener(
		"submit",
		function (event) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}

			form.classList.add("was-validated");
		},
		false
	);

	const loginModal = document.getElementById("loginModal");
	loginModal.addEventListener("hidden.bs.modal", (event) => {
		form.classList.remove("was-validated");
	});

	const registerModal = document.getElementById("registerModal");
	registerModal.addEventListener("hidden.bs.modal", (event) => {
		form.classList.remove("was-validated");
	});
});

/**
 * Validate email
 */
// var email = document.getElementById("email");
// email.oninput = () => {
//     const re =
//         /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     if (!re.test(email.value)) {
//         email.setCustomValidity("Invalid field.");
//         email.classList.add("is-invalid");
//     } else {
//         email.classList.remove("is-invalid");
//         email.setCustomValidity("");
//     }
// };
/*************** End Validation ***************/

/**
 * Autoresize echart charts
 */
const mainContainer = select("#main");
if (mainContainer) {
	setTimeout(() => {
		new ResizeObserver(function () {
			select(".echart", true).forEach((getEchart) => {
				echarts.getInstanceByDom(getEchart).resize();
			});
		}).observe(mainContainer);
	}, 200);
}

/**
 * (index.php) Counter on homepage
 */
const counterUp = window.counterUp.default;
const callback = (entries) => {
	entries.forEach((entry) => {
		const el = entry.target;
		if (entry.isIntersecting && !el.classList.contains("is-visible")) {
			counterUp(el, {
				duration: 2000,
				delay: 16,
			});
			el.classList.add("is-visible");
		}
	});
};

const IO = new IntersectionObserver(callback, {
	threshold: 1,
});

const el = document.querySelector(".counter");
IO.observe(el);

const counters = document.querySelectorAll(".counter");
for (const el of counters) {
	counterUp(el, {
		duration: 1000,
		delay: 16,
	});
}

/**
 * (index.php) Reset input in login and register form when click
 */
const loginModal = document.getElementById('loginModal')
loginModal.addEventListener('hidden.bs.modal', event => {
	document.getElementById("loginForm").reset();
})

const registerModal = document.getElementById('registerModal')
registerModal.addEventListener('hidden.bs.modal', event => {
	document.getElementById("registerForm").reset();
})

/**
 * (donator.php) Print receipt on donator dashboard
 */
function printReceipt(receiptDivName) {
	var printContents = document.getElementById(receiptDivName).innerHTML;
	var originalContents = document.body.innerHTML;

	// New content
	document.body.innerHTML = printContents;
	document.title = "Receipt";

	printWindow();

	// Original content
	document.title = "Donator Dashboard";
	document.body.innerHTML = originalContents;

	// When close the print window, reload the page
	setTimeout(function () {
		location.reload();
	});
}

function printWindow() {
	if (document.readyState === 'complete') {
		window.focus();
		window.print();
		window.close();
	} else {
		setTimeout(printWindow, 1000);
	}
}