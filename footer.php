<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package Hello Elementor Child
 */
?>

</div> <!-- close class="site" -->

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-footer' );
		} else {
			get_template_part( 'template-parts/footer' );
		}
	}
}
?>

<?php wp_footer(); ?>

<!-- Load library from the CDN -->
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

<script>     
    setTimeout(function(){
        mainText();
    }, 2000);

    setTimeout(function(){
        onComplete();
    }, 2000);

    function mainText() {
        new Typed('#typed', {
            strings: ['verify'],
            typeSpeed: 50,
            startDelay: 0,
            cursorChar: '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="75" viewBox="0 0 23 75" fill="none"><g opacity="0.82"><line x1="12" y1="1" x2="12" y2="75" stroke="#6CC4DD" stroke-width="6"></line><line y1="3.5" x2="23" y2="3.5" stroke="#6CC4DD" stroke-width="6"></line><line y1="72" x2="23" y2="72" stroke="#6CC4DD" stroke-width="6"></line></g></svg>',
        });
    }

    function onComplete() {
        new Typed('#typed-cs', {
            strings: ['soon'],
            typeSpeed: 50,
            startDelay: 0,
            cursorChar: '<svg xmlns="http://www.w3.org/2000/svg" width="23" height="75" viewBox="0 0 23 75" fill="none"><g opacity="0.82"><line x1="12" y1="1" x2="12" y2="75" stroke="#6CC4DD" stroke-width="6"></line><line y1="3.5" x2="23" y2="3.5" stroke="#6CC4DD" stroke-width="6"></line><line y1="72" x2="23" y2="72" stroke="#6CC4DD" stroke-width="6"></line></g></svg>',
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        let fbShare = document.querySelectorAll(".social-facebook");
        let twShare = document.querySelectorAll(".social-twitter");
        let liShare = document.querySelectorAll(".social-linkedin");
        let copyShare = document.querySelectorAll(".social-copy");

        // Facebook share
        fbShare?.forEach(shareBtn => {
            shareBtn.addEventListener("click", function (e) {
                e.preventDefault();
                window.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(location.href), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
            });
        });

        // Twitter share
        twShare?.forEach(shareBtn => {
            shareBtn.addEventListener("click", function (e) {
                e.preventDefault();
                const width = 400, height = 500;
                const left = (window.innerWidth - width) / 2;
                const top = (window.innerHeight - height) / 2;
                const options = `width=${width},height=${height},left=${left},top=${top}`;
                const text = "#truebit\n";
                window.open('https://twitter.com/share?url=' + encodeURIComponent(location.href) + '&text=' + encodeURIComponent(text), 'twitsharer', options);
            });
        });

        // LinkedIn share
        liShare?.forEach(shareBtn => {
            shareBtn.addEventListener("click", function (e) {
                e.preventDefault();
                const postUrl = location.href;
                const width = 400, height = 500;
                const left = (window.innerWidth - width) / 2;
                const top = (window.innerHeight - height) / 2;
                const options = `width=${width},height=${height},left=${left},top=${top}`;
                window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(postUrl)}`, 'LinkedInShareDialog', options);
            });
        });

        // Copy link share
        copyShare?.forEach(shareBtn => {
            shareBtn.addEventListener("click", function (e) {
                e.preventDefault();
                let tooltip = shareBtn.querySelector(".fwd-tooltip");
                tooltip?.classList.add("show");
                setTimeout(() => {
                    tooltip?.classList.remove("show");
                }, 1500);
                navigator.clipboard.writeText(location.href);
            });
        });
    });

document.addEventListener("DOMContentLoaded", function () {
    let lastScrollTop = 0;
    const header = document.querySelector(".main-navbar");
    const navCheckbox = document.getElementById("nav-control");

    if (!header) {
        console.warn("Header not found.");
        return;
    }

    if (!navCheckbox) {
        console.warn("Nav control checkbox not found.");
        return;
    }

    const handleScroll = () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const menuOpen = navCheckbox.checked;

        // Debug info
        //console.log("Menu open?", menuOpen, "Scroll:", scrollTop);

        if (!menuOpen) {
            if (scrollTop > lastScrollTop) {
                header.style.top = "-100px";
            } else {
                header.style.top = "0";
            }
        }

        if (scrollTop > 100 && !menuOpen) {
            header.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    };

    // Run scroll logic on load in case page is opened mid-scroll
    handleScroll();

    window.addEventListener("scroll", handleScroll);
});


</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const parent = document.querySelector('.feature-tabs-desktop');
  if (!parent) return;

  const row = parent.querySelector('.plans-row');
  if (!row) return;

  let lastY = window.pageYOffset;

  function insideParent() {
    const r = parent.getBoundingClientRect();
    // true only while the parent overlaps the viewport top and hasn't ended
    return r.top <= 0 && r.bottom > 0;
  }

  function onScroll() {
    const y = window.pageYOffset;
    const dirUp = y < lastY;
    lastY = y;

    if (insideParent()) {
      if (dirUp) {
        // 🔼 user scrolling up inside the parent
        parent.classList.add('in-up');
        parent.classList.remove('in-down');
      } else {
        // 🔽 user scrolling down inside the parent
        parent.classList.add('in-down');
        parent.classList.remove('in-up');
      }
    }
  }

  // Run events
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });

  // Initial trigger
  onScroll();

  console.log('Sticky direction tracker initialized ✅');
});
</script>

<script>


document.addEventListener('DOMContentLoaded', function () {
  const parent = document.querySelector('.pricing-tabs');
  if (!parent) return;

  function onScroll() {
    const rect = parent.getBoundingClientRect();
    const viewportBottom = window.innerHeight;

    // Add small offset (20px) at the bottom edge
    const offset = 0;

    if (viewportBottom >= rect.top && viewportBottom <= rect.bottom + offset) {
      parent.classList.add('in-tab');
    } else {
      parent.classList.remove('in-tab');
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });

  onScroll();

  console.log('Feature-tabs bottom-edge tracker initialized ✅');
});




document.addEventListener("DOMContentLoaded", function () {
  const CLASS_NAME = "no-scroll";


  document.addEventListener("click", (event) => {
    const showBtn = event.target.closest(".modal-show");
    const hideBtn = event.target.closest(".modal-hide");

    if (showBtn) {
      document.documentElement.classList.add(CLASS_NAME);
      document.body.classList.add(CLASS_NAME); // optional, but nice
    }

    if (hideBtn) {
      document.documentElement.classList.remove(CLASS_NAME);
      document.body.classList.remove(CLASS_NAME);
    }
  });
});

</script>






</body>
</html>