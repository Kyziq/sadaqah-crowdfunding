"use strict";

/**
 * DataTable Settings
 */
$(document).ready(function () {
	$('#adminEditUserTable').DataTable({
		scrollX: true,
		lengthMenu: [5, 10, 25, 50],
		displayLength: 5,
		columnDefs: [{
			targets: 'no-sort',
			orderable: false,
		}]
	});
	$('#adminEditCampaignTable, #adminEditCampaignTable2').DataTable({
		scrollX: true,
		lengthMenu: [5, 10, 25, 50],
		displayLength: 5,
		columnDefs: [{
			targets: 'no-sort',
			orderable: false,
		}]
	});
	$('#donationHistory, #acceptedDonationHistory').DataTable({
		scrollX: true,
		lengthMenu: [5, 10, 25, 50],
		displayLength: 5,
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