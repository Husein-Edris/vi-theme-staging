// obtain cookieconsent plugin
var cc = initCookieConsent();
window.cc = cc;
// example logo
// var logo = '<img src="https://wp.viplatform.net/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2023/03/logo.png.webp" alt="Logo" loading="lazy" style="margin-left: -4px; margin-bottom: -5px; height: 35px">';
var cookie = "🍪";

// run plugin with config object
cc.run({
	current_lang: "en",
	autoclear_cookies: true, // default: false
	cookie_name: "vi_cookie_consent", // default: 'cc_cookie'
	cookie_expiration: 365, // default: 182
	page_scripts: true, // default: false

	// auto_language: null,                     // default: null; could also be 'browser' or 'document'
	// autorun: true,                           // default: true
	// delay: 0,                                // default: 0
	// force_consent: false,
	// hide_from_bots: false,                   // default: false
	// remove_cookie_tables: false              // default: false
	// cookie_domain: location.hostname,        // default: current domain
	// cookie_path: "/",                        // default: root
	// cookie_same_site: "Lax",
	// use_rfc_cookie: false,                   // default: false
	// revision: 0,                             // default: 0

	gui_options: {
		consent_modal: {
			layout: "cloud", // box,cloud,bar - changed to cloud for better space
			position: "bottom center", // bottom,middle,top + left,right,center
			transition: "slide", // zoom,slide
		},
		settings_modal: {
			layout: "box", // box,bar
			// position: 'left',                // right,left (available only if bar layout selected)
			transition: "slide", // zoom,slide
		},
	},

	onFirstAction: function () {
		// Hide default buttons more aggressively
					const defaultButtonContainer = document.querySelector('#c-bns');
			if (defaultButtonContainer) {
				defaultButtonContainer.style.display = 'none';
			}
		setTimeout(function() {
			// Hide the default button container

			
			// Hide individual default buttons
			const defaultButtons = document.querySelectorAll('#c-p-bn, #c-s-bn, .c-bn:not(.cc-deny-all):not(.cc-cookie-settings):not(.cc-allow-all)');
			defaultButtons.forEach(btn => {
				btn.style.display = 'none';
			});
			
			// Ensure our custom buttons are visible
			const customButtons = document.querySelectorAll('.cc-deny-all, .cc-cookie-settings, .cc-allow-all');
			customButtons.forEach(btn => {
				btn.style.display = 'inline-block';
			});
		}, 100);
		
		// Add hover effects to custom buttons
		const customButtons = document.querySelectorAll('.cc-deny-all, .cc-cookie-settings, .cc-allow-all');
		customButtons.forEach(btn => {
			btn.addEventListener('mouseenter', function() {
				this.style.background = '#555';
			});
			btn.addEventListener('mouseleave', function() {
				this.style.background = '#666';
			});
		});
	},

	onAccept: function (cookie) {
		// Load analytics scripts if accepted
		if (cc.allowedCategory('analytics')) {
			loadAnalyticsScripts();
		}
		
		// Load advertising scripts if accepted
		if (cc.allowedCategory('advertisement')) {
			loadAdvertisingScripts();
		}
		
		// Load functional scripts if accepted
		if (cc.allowedCategory('functional')) {
			loadFunctionalScripts();
		}
		
		// Load performance scripts if accepted
		if (cc.allowedCategory('performance')) {
			loadPerformanceScripts();
		}
		
		// Re-initialize Superfish after analytics scripts load to prevent interference
		// setTimeout(function() {
		// 	if (typeof jQuery !== 'undefined' && typeof jQuery.fn.superfish !== 'undefined') {
		// 		jQuery('.sf-menu:not(.buttons)').each(function() {
		// 			var $menu = jQuery(this);
		// 			// Remove any existing arrows first
		// 			$menu.find('.sf-arrows').remove();
		// 			// Properly destroy and reinitialize
		// 			$menu.superfish('destroy').superfish({
		// 				delay: 500,
		// 				speed: 'fast',
		// 				speedOut: 'fast',
		// 				animation: { opacity: 'show' }
		// 			});
		// 		});
		// 	}
		// }, 2000);
	},

	onChange: function (cookie, changed_preferences) {
		// Handle analytics scripts
		if (changed_preferences.includes('analytics')) {
			if (cc.allowedCategory('analytics')) {
				loadAnalyticsScripts();
			} else {
				removeAnalyticsScripts();
			}
		}
		
		// Handle advertising scripts
		if (changed_preferences.includes('advertisement')) {
			if (cc.allowedCategory('advertisement')) {
				loadAdvertisingScripts();
			} else {
				removeAdvertisingScripts();
			}
		}
		
		// Handle functional scripts
		if (changed_preferences.includes('functional')) {
			if (cc.allowedCategory('functional')) {
				loadFunctionalScripts();
			} else {
				removeFunctionalScripts();
			}
		}
		
		// Handle performance scripts
		if (changed_preferences.includes('performance')) {
			if (cc.allowedCategory('performance')) {
				loadPerformanceScripts();
			} else {
				removePerformanceScripts();
			}
		}
	},

	languages: {
		"en": {
			consent_modal: {
				title: cookie + " We care about your privacy",
				description: `
					<div style="margin-bottom: 15px;">
						<p>We use cookies to enhance your browsing experience, analyze website traffic, and provide personalized content. We also share information about your use of our site with social media, advertising and analytics partners who may combine it with other information that you've provided to them or that they've collected from your use of their services.</p>
					</div>
					<div style="margin-bottom: 15px;">
						<p><strong>Cookie Categories We Use:</strong></p>
						<ul style="margin: 10px 0; padding-left: 20px; font-size: 14px;">
							<li><strong>Necessary:</strong> Essential for website functionality</li>
							<li><strong>Analytics:</strong> Help us understand how you use our website</li>
							<li><strong>Advertisement:</strong> Used to deliver relevant ads</li>
							<li><strong>Functional:</strong> Enhance website performance and functionality</li>
							<li><strong>Performance:</strong> Collect data on visitor behavior</li>
						</ul>
					</div>
					<div style="font-size: 13px; color: #666; margin-bottom: 15px;">
						<p>For more details about how we use cookies and other personal data, please read our Cookie Policy and our <a href="/privacy-policy/" class="cc-link" style="color: #0066cc;">Privacy Policy</a>.</p>
					</div>
					<div class="cc-btn-group" style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
						<button type="button" data-cc="accept-necessary" class="cc-btn cc-deny-all" style="background: #2d4156; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Deny All</button>
						<button type="button" data-cc="c-settings" class="cc-btn cc-cookie-settings" style="background: #666; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Cookie Settings</button>
						<button type="button" data-cc="accept-all" class="cc-btn cc-allow-all" style="background: #2d4156; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Allow All</button>
					</div>
				`,
				primary_btn: {
					text: "Cookie Settings",
					role: "accept_selected", // 'accept_selected' or 'accept_all'
				},
				secondary_btn: {
					text: "Deny All",
					role: "accept_necessary", // 'settings' or 'accept_necessary'
				},
				revision_message: '<br><br>Dear user, terms and conditions have changed since the last time you visited!'
			},
			settings_modal: {
				title: "Cookie Settings",
				save_settings_btn: "Save Preferences",
				accept_all_btn: "Allow All",
				reject_all_btn: "Deny All",
				close_btn_label: "Close",
				cookie_table_headers: [{col1: "Name"}, {col2: "Domain"}, {col3: "Description"}, {col4: "Expiration"}],
				blocks: [
					{
						title: "Cookie Settings 📢",
						description: `
							<p>We use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want.</p>
							<p><strong>Third-Party Data Sharing:</strong> We share information about your use of our site with social media, advertising and analytics partners who may combine it with other information that you've provided to them or that they've collected from your use of their services.</p>
							<p><strong>Managing Your Consent:</strong> You can withdraw your consent at any time by returning to this settings panel. Look for the cookie settings icon on our website or revisit this page.</p>
							<p>For more details about cookies and other sensitive data, please read our full <a href="/privacy-policy/" class="cc-link">Privacy Policy</a>.</p>
						`,
					},
					{
						title: "Strictly Necessary Cookies",
						description: "These cookies are essential for the proper functioning of our website. Without these cookies, the website would not work properly. These cookies do not store any personally identifiable information.",
						toggle: {
							value: "necessary",
							enabled: true,
							readonly: true, // cookie categories with readonly=true are all treated as "necessary cookies"
						},
						cookie_table: [
							{
								col1: "cookie-consent",
								col2: "www.virtualinternships.com",
								col3: "This cookie to remember users' consent preferences so that their preferences are respected on subsequent visits to this site. It does not collect or store any personal information about the site visitors.",
								col4: "1 year",
							},
							{
								col1: "__hssrc",
								col2: ".virtualinternships.com",
								col3: "This cookie is set by Hubspot whenever it changes the session cookie. The __hssrc cookie set to 1 indicates that the user has restarted the browser, and if the cookie does not exist, it is assumed to be a new session.",
								col4: "session",
							},
							{
								col1: "__hssc",
								col2: ".virtualinternships.com",
								col3: "HubSpot sets this cookie to keep track of sessions and to determine if HubSpot should increment the session number and timestamps in the __hstc cookie.",
								col4: "30 minutes",
							},
						],
					},
					{
						title: "Advertisement cookies",
						description: "An advertising cookie is nothing more than a small piece of data that catalogs the behavior of all users",
						toggle: {
							value: "advertisement", // there are no default categories => you specify them
							enabled: false,
							readonly: false,
						},
						cookie_table: [
							{
								col1: "test_cookie",
								col2: ".doubleclick.net",
								col3: "doubleclick.net sets this cookie to determine if the user's browser supports cookies.",
								col4: "15 minutes",
							},
							{
								col1: "li_sugr",
								col2: ".linkedin.com",
								col3: "LinkedIn sets this cookie to collect user behaviour data to optimise the website and make advertisements on the website more relevant.",
								col4: "3 months",
							},
							{
								col1: "bcookie",
								col2: ".linkedin.com",
								col3: "LinkedIn sets this cookie from LinkedIn share buttons and ad tags to recognize browser IDs.",
								col4: "1 year",
							},
							{
								col1: "bscookie",
								col2: ".www.linkedin.com",
								col3: "LinkedIn sets this cookie to store performed actions on the website.",
								col4: "1 year",
							},
							{
								col1: "IDE",
								col2: ".doubleclick.net",
								col3: "Google DoubleClick IDE cookies store information about how the user uses the website to present them with relevant ads according to the user profile.",
								col4: "1 year 24 days",
							},
							{
								col1: "MUID",
								col2: ".clarity.ms",
								col3: "Bing sets this cookie to recognise unique web browsers visiting Microsoft sites. This cookie is used for advertising, site analytics, and other operations.",
								col4: "1 year 24 days",
							},
							{
								col1: "MUID",
								col2: ".bing.com",
								col3: "Bing sets this cookie to recognise unique web browsers visiting Microsoft sites. This cookie is used for advertising, site analytics, and other operations.",
								col4: "1 year 24 days",
							},
							{
								col1: "ANONCHK",
								col2: ".c.clarity.ms",
								col3: "The ANONCHK cookie, set by Bing, is used to store a user's session ID and verify ads' clicks on the Bing search engine. The cookie helps in reporting and personalization as well.",
								col4: "10 minutes",
							},
							{
								col1: "YSC",
								col2: ".youtube.com",
								col3: "Youtube sets this cookie to track the views of embedded videos on Youtube pages.",
								col4: "session",
							},
							{
								col1: "VISITOR_INFO1_LIVE",
								col2: ".youtube.com",
								col3: "YouTube sets this cookie to measure bandwidth, determining whether the user gets the new or old player interface.",
								col4: "5 months 27 days",
							},
							{
								col1: "yt-remote-device-id",
								col2: "youtube.com",
								col3: "YouTube sets this cookie to store the user's video preferences using embedded YouTube videos.",
								col4: "never",
							},
							{
								col1: "yt.innertube::requests",
								col2: "youtube.com",
								col3: "YouTube sets this cookie to register a unique ID to store data on what videos from YouTube the user has seen.",
								col4: "never",
							},
							{
								col1: "yt.innertube::nextId",
								col2: "youtube.com",
								col3: "YouTube sets this cookie to register a unique ID to store data on what videos from YouTube the user has seen.",
								col4: "never",
							},
						],
					},
					{
						title: "Analytics cookies",
						description: "Analytics cookies are cookies that track how users navigate and interact with a website.",
						toggle: {
							value: "analytics",
							enabled: false,
							readonly: false,
						},
						cookie_table: [
							{
								col1: "_gcl_au",
								col2: ".virtualinternships.com",
								col3: "Google Tag Manager sets the cookie to experiment advertisement efficiency of websites using their services.",
								col4: "3 months",
							},
							{
								col1: "CLID",
								col2: "www.clarity.ms",
								col3: "Microsoft Clarity set this cookie to store information about how visitors interact with the website. The cookie helps to provide an analysis report. The data collection includes the number of visitors, where they visit the website, and the pages visited.",
								col4: "1 year",
							},
							{
								col1: "ln_or",
								col2: "www.virtualinternships.com",
								col3: "Linkedin sets this cookie to registers statistical data on users' behaviour on the website for internal analytics.",
								col4: "1 day",
							},
							{
								col1: "_ga",
								col2: ".virtualinternships.com",
								col3: "Google Analytics sets this cookie to calculate visitor, session and campaign data and track site usage for the site's analytics report. The cookie stores information anonymously and assigns a randomly generated number to recognise unique visitors.",
								col4: "1 year 1 month 4 days",
							},
							{
								col1: "_gid",
								col2: ".virtualinternships.com",
								col3: "Google Analytics sets this cookie to store information on how visitors use a website while also creating an analytics report of the website's performance. Some of the collected data includes the number of visitors, their source, and the pages they visit anonymously.",
								col4: "1 day",
							},
							{
								col1: "AnalyticsSyncHistory",
								col2: ".linkedin.com",
								col3: "Linkedin set this cookie to store information about the time a sync took place with the lms_analytics cookie.",
								col4: "1 month",
							},
							{
								col1: "_gat_UA-*",
								col2: ".virtualinternships.com",
								col3: "Google Analytics sets this cookie for user behaviour tracking.",
								col4: "1 minute",
							},
							{
								col1: "_ga_*",
								col2: ".virtualinternships.com",
								col3: "Google Analytics sets this cookie to store and count page views.",
								col4: "1 year 1 month 4 days",
							},
							{
								col1: "_fbp",
								col2: ".virtualinternships.com",
								col3: "Facebook sets this cookie to display advertisements when either on Facebook or on a digital platform powered by Facebook advertising after visiting the website.",
								col4: "3 months",
							},
							{
								col1: "_clck",
								col2: ".virtualinternships.com",
								col3: "Microsoft Clarity sets this cookie to retain the browser's Clarity User ID and settings exclusive to that website. This guarantees that actions taken during subsequent visits to the same website will be linked to the same user ID.",
								col4: "1 year",
							},
							{
								col1: "_hjSessionUser_*",
								col2: ".virtualinternships.com",
								col3: "Hotjar sets this cookie to ensure data from subsequent visits to the same site is attributed to the same user ID, which persists in the Hotjar User ID, which is unique to that site.",
								col4: "1 year",
							},
							{
								col1: "_hjFirstSeen",
								col2: ".virtualinternships.com",
								col3: "Hotjar sets this cookie to identify a new user's first session. It stores the true/false value, indicating whether it was the first time Hotjar saw this user.",
								col4: "30 minutes",
							},
							{
								col1: "_hjSession_*",
								col2: ".virtualinternships.com",
								col3: "Hotjar sets this cookie to ensure data from subsequent visits to the same site is attributed to the same user ID, which persists in the Hotjar User ID, which is unique to that site.",
								col4: "30 minutes",
							},
							{
								col1: "_clsk",
								col2: ".virtualinternships.com",
								col3: "Microsoft Clarity sets this cookie to store and consolidate a user's pageviews into a single session recording.",
								col4: "1 day",
							},
							{
								col1: "_ga_*",
								col2: ".virtualinternships.com",
								col3: "Google Analytics sets this cookie to store and count page views.",
								col4: "1 year 1 month 4 days",
							},
							{
								col1: "__hstc",
								col2: ".virtualinternships.com",
								col3: "Hubspot set this main cookie for tracking visitors. It contains the domain, initial timestamp (first visit), last timestamp (last visit), current timestamp (this visit), and session number (increments for each subsequent session).",
								col4: "5 months 27 days",
							},
							{
								col1: "hubspotutk",
								col2: ".virtualinternships.com",
								col3: "HubSpot sets this cookie to keep track of the visitors to the website. This cookie is passed to HubSpot on form submission and used when deduplicating contacts.",
								col4: "5 months 27 days",
							},
							{
								col1: "SM",
								col2: ".c.clarity.ms",
								col3: "Microsoft Clarity cookie set this cookie for synchronizing the MUID across Microsoft domains.",
								col4: "session",
							},
							{
								col1: "MR",
								col2: ".c.bing.com",
								col3: "This cookie, set by Bing, is used to collect user information for analytics purposes.",
								col4: "7 days",
							},
							{
								col1: "CONSENT",
								col2: ".youtube.com",
								col3: "YouTube sets this cookie via embedded YouTube videos and registers anonymous statistical data.",
								col4: "2 years",
							},
						],
					},
					{
						title: "Functional cookies",
						description: "Functionality cookies are cookies that help enhance a website performance and functionality",
						toggle: {
							value: "functional",
							enabled: false,
							readonly: false,
						},
						cookie_table: [
							{
								col1: "lidc",
								col2: ".linkedin.com",
								col3: "LinkedIn sets the lidc cookie to facilitate data center selection.",
								col4: "1 day",
							},
							{
								col1: "UserMatchHistory",
								col2: ".linkedin.com",
								col3: "LinkedIn sets this cookie for LinkedIn Ads ID syncing.",
								col4: "1 month",
							},
							{
								col1: "li_gc",
								col2: ".linkedin.com",
								col3: "Linkedin set this cookie for storing visitor's consent regarding using cookies for non-essential purposes.",
								col4: "5 months 27 days",
							},
							{
								col1: "_hjAbsoluteSessionInProgress",
								col2: ".virtualinternships.com",
								col3: "Hotjar sets this cookie to detect a user's first pageview session, which is a True/False flag set by the cookie.",
								col4: "30 minutes",
							},
							{
								col1: "__cf_bm",
								col2: ".hubspot.com",
								col3: "Cloudflare set the cookie to support Cloudflare Bot Management.",
								col4: "30 minutes",
							},
						],
					},
					{
						title: "Performance cookies",
						description: "Performance cookies are used for collecting data on how visitors behave on a website.",
						toggle: {
							value: "performance",
							enabled: false,
							readonly: false,
						},
						cookie_table: [
							{
								col1: "SRM_B",
								col2: ".c.bing.com",
								col3: "Used by Microsoft Advertising as a unique ID for visitors.",
								col4: "1 year 24 days",
							},
						],
					},
					{
						title: "More information",
						description: 'For any queries in relation to my policy on cookies and your choices, please <a class="cc-link" href="https://www.virtualinternships.com/contact-us/">contact us</a>.',
					},
				],
			},
		},
	},
});

// Script Loading Functions
function loadAnalyticsScripts() {
	
	// Google Tag Manager
	if (!document.getElementById('gtm-script')) {
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;j.id='gtm-script';f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-TNPDKHJ');
	}
	
	// Google Analytics (if not handled by GTM)
	if (!window.gtag && !document.getElementById('ga-script')) {
		var script = document.createElement('script');
		script.async = true;
		script.src = 'https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID';
		script.id = 'ga-script';
		document.head.appendChild(script);
		
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'GA_MEASUREMENT_ID');
	}
	
	// Microsoft Clarity with Consent API
	if (!window.clarity && !document.getElementById('clarity-script')) {
		(function(c,l,a,r,i,t,y){
			c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
			t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
			t.id='clarity-script';y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
			
			// Signal consent to Clarity after script loads
			t.onload = function() {
				if (window.clarity) {
					window.clarity("consent");
				}
			};
		})(window, document, "clarity", "script", "hd15812ds4");
	}
	
	// HubSpot Tracking
	if (!window._hsq && !document.getElementById('hubspot-script')) {
		var _hsq = window._hsq = window._hsq || [];
		var script = document.createElement('script');
		script.async = true;
		script.src = '//js-eu1.hs-scripts.com/26293027.js';
		script.id = 'hubspot-script';
		document.head.appendChild(script);
	}
	
	// Leadsy.ai Tracking (includes Microsoft Clarity)
	if (!document.getElementById('leadsy-script')) {
		var script = document.createElement('script');
		script.async = true;
		script.src = 'https://r2.leadsy.ai/tag.js';
		script.setAttribute('data-pid', 'ZxRM42MpXjmBhnfD');
		script.setAttribute('data-version', '062024');
		script.id = 'leadsy-script';
		document.head.appendChild(script);
	}
}

function loadAdvertisingScripts() {
	
	// Meta Pixel (Facebook)
	if (!window.fbq && !document.getElementById('fb-pixel-script')) {
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;t.id='fb-pixel-script';s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', 'YOUR_PIXEL_ID');
		fbq('track', 'PageView');
	}
	
	// LinkedIn Ads
	if (!window._linkedin_partner_id && !document.getElementById('linkedin-ads-script')) {
		window._linkedin_partner_id = "YOUR_LINKEDIN_PARTNER_ID";
		window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
		window._linkedin_data_partner_ids.push(_linkedin_partner_id);
		
		var script = document.createElement('script');
		script.async = true;
		script.src = 'https://snap.licdn.com/li.lms-analytics/insight.min.js';
		script.id = 'linkedin-ads-script';
		document.head.appendChild(script);
	}
}

function loadFunctionalScripts() {
	
	// Apollo.io Tracking
	if (!document.getElementById('apollo-script')) {
		function initApollo() {
			var n = Math.random().toString(36).substring(7),
				o = document.createElement("script");
			o.src = "https://assets.apollo.io/micro/website-tracker/tracker.iife.js?nocache=" + n;
			o.async = !0;
			o.defer = !0;
			o.id = 'apollo-script';
			o.onload = function() {
				window.trackingFunctions.onLoad({
					appId: "6631e6214d975a07dccb2862"
				})
			};
			document.head.appendChild(o);
		}
		initApollo();
	}
}

function loadPerformanceScripts() {
	
	// Hotjar
	if (!window.hj && !document.getElementById('hotjar-script')) {
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			// h._hjSettings={hjid:YOUR_HOTJAR_ID,hjsv:6};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			r.id='hotjar-script';a.appendChild(r);
		})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	}
}

// Script Removal Functions
function removeAnalyticsScripts() {
	
	// Remove GTM script
	var gtmScript = document.getElementById('gtm-script');
	if (gtmScript) gtmScript.remove();
	
	// Remove GA script
	var gaScript = document.getElementById('ga-script');
	if (gaScript) gaScript.remove();
	
	// Revoke Clarity consent and remove script
	if (window.clarity) {
		window.clarity("consent", false);
	}
	var clarityScript = document.getElementById('clarity-script');
	if (clarityScript) clarityScript.remove();
	
	// Remove HubSpot script
	var hubspotScript = document.getElementById('hubspot-script');
	if (hubspotScript) hubspotScript.remove();
	
	// Remove Leadsy script
	var leadsyScript = document.getElementById('leadsy-script');
	if (leadsyScript) leadsyScript.remove();
	
	// Clear related cookies
	clearCookiesByCategory(['_ga', '_gid', '_gat', '__hstc', '__hssc', '__hssrc', 'hubspotutk', '_clck', '_clsk', 'CLID']);
}

function removeAdvertisingScripts() {
	
	// Remove Facebook Pixel script
	var fbScript = document.getElementById('fb-pixel-script');
	if (fbScript) fbScript.remove();
	
	// Remove LinkedIn Ads script
	var linkedinScript = document.getElementById('linkedin-ads-script');
	if (linkedinScript) linkedinScript.remove();
	
	// Clear related cookies
	clearCookiesByCategory(['_fbp', '_fbc', 'li_sugr', 'bcookie', 'bscookie', 'AnalyticsSyncHistory']);
}

function removeFunctionalScripts() {
	
	// Remove Apollo script
	var apolloScript = document.getElementById('apollo-script');
	if (apolloScript) apolloScript.remove();
	
	// Clear related cookies
	clearCookiesByCategory(['lidc', 'UserMatchHistory', 'li_gc', '_hjAbsoluteSessionInProgress', '__cf_bm']);
}

function removePerformanceScripts() {
	
	// Remove Hotjar script
	var hotjarScript = document.getElementById('hotjar-script');
	if (hotjarScript) hotjarScript.remove();
	
	// Clear related cookies
	clearCookiesByCategory(['_hjSessionUser_', '_hjFirstSeen', '_hjSession_', 'SRM_B']);
}

function clearCookiesByCategory(cookieNames) {
	cookieNames.forEach(function(cookieName) {
		// Clear cookie for current domain
		document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
		document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + window.location.hostname + ';';
		document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + window.location.hostname + ';';
		
		// Handle wildcard cookies (e.g., _ga_*, _hjSessionUser_*)
		if (cookieName.includes('_')) {
			var cookies = document.cookie.split(';');
			cookies.forEach(function(cookie) {
				var eqPos = cookie.indexOf('=');
				var name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
				if (name.startsWith(cookieName)) {
					document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
					document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=' + window.location.hostname + ';';
					document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + window.location.hostname + ';';
				}
			});
		}
	});
}


document.addEventListener('DOMContentLoaded', function() {
    var cookieSettingsLink = document.getElementById('open-cookie-settings');
    if (cookieSettingsLink && typeof window.cc !== 'undefined') {
        cookieSettingsLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof window.cc.showSettings === 'function') {
                window.cc.showSettings();
            } else if (typeof window.cc !== 'undefined' && typeof window.cc.show === 'function') {
                window.cc.show();
            }
        });
    }
});
