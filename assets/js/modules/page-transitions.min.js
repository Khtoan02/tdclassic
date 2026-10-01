/**
 * TD Classic - Seamless Persistent Header & Ultra-Fast Page Transitions
 * - Persistent header across page navigations without page reload flicker
 * - Instant back/forward navigation using in-memory page cache
 * - Single-request on-demand loading on user click (Zero hover prefetch spam)
 * - Safe 3.5s timeout with automatic native browser fallback
 * - Real-time active navigation states in desktop header & mobile drawer
 * - Dynamic head assets (CSS & scripts) synchronization
 */
(function () {
  'use strict';

  // In-memory cache for instant subsequent navigations
  const pageCache = new Map();
  let isNavigating = false;
  let activeAbort = null;

  // Seed initial page into cache for 0ms return navigation
  if (typeof document !== 'undefined' && document.documentElement) {
    const initialHtml = '<!DOCTYPE html>' + document.documentElement.outerHTML;
    pageCache.set(window.location.href, initialHtml);
    try {
      const initUrl = new URL(window.location.href);
      pageCache.set(initUrl.origin + initUrl.pathname, initialHtml);
    } catch (e) {}
  }

  // 1. Sleek luxury gold top loading bar
  const progressBar = document.createElement('div');
  progressBar.id = 'td-page-progress';
  progressBar.style.cssText =
    'position:fixed;top:0;left:0;height:2.5px;width:0%;background:linear-gradient(90deg, #C5A059, #F5D77F);box-shadow:0 0 10px rgba(197,160,89,0.8);z-index:999999;transition:width 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;pointer-events:none;opacity:0;';
  document.body.appendChild(progressBar);

  let progressTimer = null;
  function startProgress() {
    clearTimeout(progressTimer);
    progressBar.style.opacity = '1';
    progressBar.style.width = '35%';
    progressTimer = setTimeout(() => {
      if (isNavigating) progressBar.style.width = '75%';
    }, 120);
  }

  function finishProgress() {
    clearTimeout(progressTimer);
    progressBar.style.width = '100%';
    setTimeout(() => {
      progressBar.style.opacity = '0';
      setTimeout(() => {
        progressBar.style.width = '0%';
      }, 250);
    }, 120);
  }

  // 2. Check if a URL should be handled seamlessly
  function isInternalNavigableUrl(url) {
    try {
      const parsed = new URL(url, window.location.href);
      // Same origin only
      if (parsed.origin !== window.location.origin) return false;
      // Exclude admin, login, checkout, custom endpoints
      const path = parsed.pathname;
      if (path.includes('/wp-admin') || path.includes('/wp-login.php') || path.includes('/wp-json')) return false;
      if (parsed.searchParams.has('wc-ajax') || parsed.searchParams.has('action')) return false;
      // Exclude binary / media downloads
      if (path.match(/\.(pdf|zip|tar|gz|rar|docx?|xlsx?|pptx?|jpe?g|png|webp|gif|svg|mp4|mp3)$/i)) return false;
      return true;
    } catch (e) {
      return false;
    }
  }

  // 3. Update Navigation Links Active States in Header & Drawer
  function updateNavActiveStates(targetUrl) {
    let targetPath = '/';
    try {
      const parsedTarget = new URL(targetUrl, window.location.href);
      targetPath = parsedTarget.pathname.replace(/\/$/, '') || '/';
    } catch (e) {}

    // Desktop Nav Links
    document.querySelectorAll('#main-header .nav-link').forEach((link) => {
      const href = link.getAttribute('href');
      if (!href) return;
      try {
        const linkParsed = new URL(href, window.location.href);
        const linkPath = linkParsed.pathname.replace(/\/$/, '') || '/';

        const isMatch = (targetPath === '/' && linkPath === '/') || (linkPath !== '/' && targetPath.startsWith(linkPath));
        if (isMatch) {
          link.classList.add('active', 'text-gold');
          link.classList.remove('text-gray-400');
        } else {
          link.classList.remove('active', 'text-gold');
          link.classList.add('text-gray-400');
        }
      } catch (e) {}
    });

    // Mobile Drawer Links
    document.querySelectorAll('.mobile-drawer .mob-link, .mobile-drawer .mob-sub-link').forEach((link) => {
      const href = link.getAttribute('href');
      if (!href) return;
      try {
        const linkParsed = new URL(href, window.location.href);
        const linkPath = linkParsed.pathname.replace(/\/$/, '') || '/';

        const isMatch = (targetPath === '/' && linkPath === '/') || (linkPath !== '/' && targetPath === linkPath);
        if (isMatch) {
          link.style.color = '#C5A059';
        } else {
          link.style.color = '';
        }
      } catch (e) {}
    });
  }

  // 4. Update Category Bar visibility and content
  function updateCategoryBar(newDoc) {
    const currentBottom = document.querySelector('.header-bottom-wrapper');
    const newBottom = newDoc.querySelector('.header-bottom-wrapper');
    if (currentBottom && newBottom) {
      currentBottom.className = newBottom.className;
      currentBottom.innerHTML = newBottom.innerHTML;
    }
  }

  // 5. Dynamic Head Assets (Stylesheets & External Scripts)
  function updateHeadAssets(newDoc) {
    // Sync missing stylesheets
    const currentStyles = new Set(Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map((l) => l.href));
    newDoc.querySelectorAll('link[rel="stylesheet"]').forEach((link) => {
      if (link.href && !currentStyles.has(link.href)) {
        const newLink = document.createElement('link');
        newLink.rel = 'stylesheet';
        newLink.href = link.href;
        if (link.id) newLink.id = link.id;
        if (link.media) newLink.media = link.media;
        document.head.appendChild(newLink);
      }
    });

    // Sync external head scripts (e.g., Turnstile)
    const currentScripts = new Set(Array.from(document.querySelectorAll('head script[src]')).map((s) => s.src));
    newDoc.querySelectorAll('head script[src]').forEach((script) => {
      if (script.src && !currentScripts.has(script.src)) {
        const newScript = document.createElement('script');
        Array.from(script.attributes).forEach((attr) => newScript.setAttribute(attr.name, attr.value));
        document.head.appendChild(newScript);
      }
    });
  }

  // 6. Execute scripts embedded in the new content
  function executeNewScripts(container) {
    const scripts = container.querySelectorAll('script');
    scripts.forEach((oldScript) => {
      const newScript = document.createElement('script');
      Array.from(oldScript.attributes).forEach((attr) => newScript.setAttribute(attr.name, attr.value));
      newScript.textContent = oldScript.textContent;
      oldScript.parentNode.replaceChild(newScript, oldScript);
    });
  }

  // 7. Re-initialize page widgets & interactive features
  function reinitPageFeatures() {
    // Lucide Icons
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
      window.lucide.createIcons();
    }
    // Wave bars and animation delays
    document.querySelectorAll('[data-animation-delay]').forEach((el) => {
      el.style.setProperty('--animation-delay', el.dataset.animationDelay + 's');
    });
    // Trigger custom events so theme modules know content swapped
    window.dispatchEvent(new Event('DOMContentLoaded'));
    window.dispatchEvent(new Event('tdclassic:page-transitioned'));
  }

  // 8. Swap DOM content
  async function renderPageHtml(html, canonicalUrl, pushState) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    // Check for canonical link in document
    const canonicalTag = doc.querySelector('link[rel="canonical"]');
    if (canonicalTag && canonicalTag.href) {
      canonicalUrl = canonicalTag.href;
    }

    const currentMain = document.getElementById('main-content');
    const newMain = doc.getElementById('main-content');

    if (!currentMain || !newMain) {
      window.location.href = canonicalUrl;
      return;
    }

    // Synchronize head assets (CSS & scripts) before swapping DOM
    updateHeadAssets(doc);

    // DOM Swap function
    const performSwap = () => {
      // Update Title
      document.title = doc.title;

      // Update Body Classes (for page-specific layouts)
      document.body.className = doc.body.className;

      // Swap Content inside Main without touching Header or Footer!
      currentMain.innerHTML = newMain.innerHTML;
      currentMain.className = newMain.className;

      // Update browser history synchronously with DOM swap
      if (pushState) {
        window.history.pushState({ url: canonicalUrl }, doc.title, canonicalUrl);
      }

      // Update Header Nav & Category Bar
      updateNavActiveStates(canonicalUrl);
      updateCategoryBar(doc);

      // Reset scroll position to top
      window.scrollTo({ top: 0, behavior: 'instant' });

      // Execute any new inline scripts
      executeNewScripts(currentMain);

      // Re-init interactive components
      reinitPageFeatures();
    };

    // Native View Transitions if supported by browser
    if (document.startViewTransition) {
      await document.startViewTransition(performSwap).finished;
    } else {
      // Fast, elegant CSS crossfade fallback
      currentMain.style.transition = 'opacity 0.12s ease, transform 0.12s ease';
      currentMain.style.opacity = '0';
      currentMain.style.transform = 'translateY(4px)';

      await new Promise((r) => setTimeout(r, 120));
      performSwap();

      currentMain.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
      currentMain.style.opacity = '1';
      currentMain.style.transform = 'translateY(0)';
    }
  }

  // 9. Core Page Loader (Single Request on Demand)
  async function loadPage(url, pushState = true) {
    if (isNavigating) return;
    if (url === window.location.href && pushState) return;

    // Close Mobile Drawer if open
    const overlay = document.getElementById('mobile-menu-overlay');
    if (overlay && overlay.classList.contains('open')) {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    // 1. Instant cache check (0ms for visited pages)
    let cachedHtml = pageCache.get(url);
    if (!cachedHtml) {
      try {
        const u = new URL(url, window.location.href);
        cachedHtml = pageCache.get(u.origin + u.pathname);
      } catch (e) {}
    }

    if (cachedHtml) {
      startProgress();
      await renderPageHtml(cachedHtml, url, pushState);
      finishProgress();
      return;
    }

    // 2. Single on-demand fetch with 7.5s safety timeout
    isNavigating = true;
    startProgress();

    if (activeAbort) {
      activeAbort.abort();
    }
    activeAbort = new AbortController();
    const abortTimeout = setTimeout(() => {
      if (activeAbort) activeAbort.abort('Timeout');
    }, 7500);

    try {
      const res = await fetch(url, {
        headers: { 'X-Requested-With': 'TDClassic-SPA' },
        credentials: 'same-origin',
        signal: activeAbort.signal,
      });
      clearTimeout(abortTimeout);

      if (!res.ok) throw new Error('HTTP ' + res.status);
      const canonicalUrl = res.url || url;
      const html = await res.text();

      pageCache.set(url, html);
      if (canonicalUrl !== url) {
        pageCache.set(canonicalUrl, html);
      }

      await renderPageHtml(html, canonicalUrl, pushState);
    } catch (err) {
      clearTimeout(abortTimeout);
      console.warn('[TD Classic] Seamless navigation fallback to full load:', err);
      window.location.href = url;
    } finally {
      finishProgress();
      isNavigating = false;
      activeAbort = null;
    }
  }

  // 10. Intercept link clicks only (No background hover spam)
  document.addEventListener('click', function (e) {
    const link = e.target.closest('a');
    if (!link) return;

    // Ignore clicks with modifiers (Cmd/Ctrl + click to open in new tab)
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:')) {
      return;
    }

    if (link.getAttribute('target') === '_blank' || link.hasAttribute('download')) {
      return;
    }

    if (!isInternalNavigableUrl(link.href)) return;

    e.preventDefault();
    loadPage(link.href, true);
  });

  // 11. Handle Browser Back & Forward
  window.addEventListener('popstate', function () {
    loadPage(window.location.href, false);
  });

  // Expose global helper
  window.tdclassicNavigate = loadPage;
})();
