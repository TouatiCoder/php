(function () {
  const translations = window.AQCHA_TRANSLATIONS || {};
  const locales = window.AQCHA_LOCALES || ["en", "fr", "ar"];
  const localeLabels = window.AQCHA_LOCALE_LABELS || {
    en: "English",
    fr: "Francais",
    ar: "Arabic",
  };

  const pageTitles = {
    home: "AQCHA \u2014 Tomorrow's Packaging Starts With Yesterday's Waste",
    crisis: "AQCHA \u2014 Crisis",
    revolution: "AQCHA \u2014 Revolution",
    why: "AQCHA \u2014 Why Us",
    products: "AQCHA \u2014 Products",
    impact: "AQCHA \u2014 Impact",
    contact: "AQCHA \u2014 Contact",
  };

  const pageDescriptions = {
    home:
      "AQCHA transforms Moroccan fruit and vegetable waste into 100% biodegradable, plastic-free packaging. The future of sustainable packaging starts here.",
    crisis:
      "Understand the plastic crisis and AQCHA's circular solution for biodegradable packaging.",
    revolution:
      "Discover AQCHA's circular revolution from organic waste to biodegradable packaging.",
    why:
      "See why AQCHA's packaging is different, regenerative, and built for a plastic-free future.",
    products:
      "Browse AQCHA's biodegradable, compostable product range made from organic waste.",
    impact:
      "Review AQCHA's measurable environmental impact through waste recovery and emissions reduction.",
    contact:
      "Whether you're a brand, investor or institution, contact AQCHA to build the post-plastic world together.",
  };

  const icons = {
    arrowRight: [
      ["path", { d: "M5 12h14" }],
      ["path", { d: "m12 5 7 7-7 7" }],
    ],
    arrowUpRight: [
      ["path", { d: "M7 7h10v10" }],
      ["path", { d: "M7 17 17 7" }],
    ],
    factory: [
      ["path", { d: "M12 16h.01" }],
      ["path", { d: "M16 16h.01" }],
      [
        "path",
        {
          d: "M3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a.5.5 0 0 0-.769-.422l-4.462 2.844A.5.5 0 0 1 15 10.5v-2a.5.5 0 0 0-.769-.422L9.77 10.922A.5.5 0 0 1 9 10.5V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z",
        },
      ],
      ["path", { d: "M8 16h.01" }],
    ],
    leaf: [
      [
        "path",
        {
          d: "M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z",
        },
      ],
      ["path", { d: "M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" }],
    ],
    mail: [
      ["path", { d: "m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" }],
      ["rect", { x: "2", y: "4", width: "20", height: "16", rx: "2" }],
    ],
    mapPin: [
      [
        "path",
        {
          d: "M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0",
        },
      ],
      ["circle", { cx: "12", cy: "10", r: "3" }],
    ],
    recycle: [
      [
        "path",
        {
          d: "M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5",
        },
      ],
      [
        "path",
        {
          d: "M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12",
        },
      ],
      ["path", { d: "m14 16-3 3 3 3" }],
      ["path", { d: "M8.293 13.596 7.196 9.5 3.1 10.598" }],
      [
        "path",
        {
          d: "m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843",
        },
      ],
      ["path", { d: "m13.378 9.633 4.096 1.098 1.097-4.096" }],
    ],
    sparkles: [
      [
        "path",
        {
          d: "M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z",
        },
      ],
      ["path", { d: "M20 2v4" }],
      ["path", { d: "M22 4h-4" }],
      ["circle", { cx: "4", cy: "20", r: "2" }],
    ],
    sprout: [
      [
        "path",
        {
          d: "M14 9.536V7a4 4 0 0 1 4-4h1.5a.5.5 0 0 1 .5.5V5a4 4 0 0 1-4 4 4 4 0 0 0-4 4c0 2 1 3 1 5a5 5 0 0 1-1 3",
        },
      ],
      ["path", { d: "M4 9a5 5 0 0 1 8 4 5 5 0 0 1-8-4" }],
      ["path", { d: "M5 21h14" }],
    ],
    wind: [
      ["path", { d: "M12.8 19.6A2 2 0 1 0 14 16H2" }],
      ["path", { d: "M17.5 8a2.5 2.5 0 1 1 2 4H2" }],
      ["path", { d: "M9.8 4.4A2 2 0 1 1 11 8H2" }],
    ],
  };

  const whyIcons = ["leaf", "sprout", "factory", "mapPin", "recycle", "wind"];
  const imageNames = {
    waste: "waste.jpg",
    bag: "product-bag.jpg",
    box: "product-box.jpg",
    future: "future.jpg",
    futureProduct: "product-future.jpg",
  };

  let currentPage = "home";
  let currentLocale = "en";

  function escapeHtml(value) {
    return String(value ?? "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#39;");
  }

  function attrsToString(attrs) {
    return Object.entries(attrs)
      .map(([key, value]) => `${key}="${escapeHtml(value)}"`)
      .join(" ");
  }

  function icon(name, className) {
    const nodes = icons[name] || [];
    const body = nodes
      .map(([tag, attrs]) => `<${tag} ${attrsToString(attrs)}></${tag}>`)
      .join("");
    return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="${className || ""}">${body}</svg>`;
  }

  function getPreferredLocale() {
    const saved = window.localStorage.getItem("locale");
    if (saved && locales.includes(saved)) return saved;
    const nav = (window.navigator.language || "").slice(0, 2).toLowerCase();
    if (nav === "fr" || nav === "ar") return nav;
    return "en";
  }

  function applyDocumentLocale(locale) {
    document.documentElement.lang = locale;
    document.documentElement.dir = locale === "ar" ? "rtl" : "ltr";
    window.localStorage.setItem("locale", locale);
  }

  const nestedPages = ["products", "crisis", "revolution", "why", "impact", "contact"];

  function isNestedPage() {
    return nestedPages.includes(currentPage);
  }

  function assetUrl(key) {
    const base = isNestedPage() ? "../assets/images" : "assets/images";
    const value = String(key || '');
    if (value.startsWith('http://') || value.startsWith('https://') || value.startsWith('//')) {
      return value;
    }
    if (value.startsWith('/')) {
      return value.substring(1);
    }
    if (value.includes('assets/images/')) {
      return value.replace('assets/images/', `${base}/`);
    }
    if (imageNames[value]) {
      return `${base}/${imageNames[value]}`;
    }
    return `${base}/${value}`;
  }
  function routeHref(to) {
    const page = String(to || "").replace("/", "") || "home";
    if (page === "home") return isNestedPage() ? "../index.php" : "index.php";
    return isNestedPage() ? `${page}.php` : `pages/${page}.php`;
  }

  function homeHash(hash) {
    return isNestedPage() ? `../index.php${hash}` : hash;
  }

  function productHref(id) {
    const page = isNestedPage() ? '../product.php' : 'product.php';
    return `${page}?id=${encodeURIComponent(id)}`;
  }

  function siteUrl(path) {
    return isNestedPage() ? `../${path}` : path;
  }

  function apiUrl(path) {
    return siteUrl(`api/${path}`);
  }

  function counterInitial(metric) {
    return `0${metric.suffix || ""}`;
  }

  function formatCounter(value, decimals) {
    return Number(value).toLocaleString("en-US", {
      minimumFractionDigits: decimals || 0,
      maximumFractionDigits: decimals || 0,
    });
  }

  function motionStyle(y, duration, delay) {
    return `--motion-y:${y}px;--motion-duration:${duration}s;--motion-delay:${delay}s;`;
  }

  function nav(strings) {
    const options = locales
      .map(
        (locale) =>
          `<option value="${locale}" class="bg-[var(--forest-deep)] text-[var(--cream)]">${escapeHtml(localeLabels[locale])}</option>`,
      )
      .join("");
    const links = strings.nav.links
      .map(
        (link) =>
          `<a href="${routeHref(link.to)}" class="px-4 py-2 rounded-full opacity-80 hover:opacity-100 hover:bg-white/10 transition">${escapeHtml(link.label)}</a>`,
      )
      .join("");

    return `
      <header class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-5 px-4">
        <nav class="bg-[var(--forest-deep)] rounded-full px-2 py-2 flex flex-wrap items-center gap-2 text-[var(--cream)] shadow-[0_10px_40px_-15px_rgba(0,0,0,0.35)]">
          <a href="${homeHash("#top")}" class="pl-4 pr-6 font-display text-xl tracking-tight">
            ${escapeHtml(strings.nav.brand)}<span class="text-[var(--amber)]">.</span>
          </a>
          <div class="hidden md:flex items-center gap-1 text-sm">
            ${links}
          </div>
          <div class="flex items-center gap-2 ml-auto">
            <a href="${homeHash("#contact")}" class="inline-flex items-center gap-1.5 rounded-full bg-[var(--amber)] text-[var(--forest-deep)] pl-5 pr-4 py-2 text-sm font-medium hover:scale-[1.03] transition">
              ${escapeHtml(strings.nav.joinMovement)} ${icon("arrowUpRight", "w-4 h-4")}
            </a>
            <select data-locale-select class="rounded-full bg-[var(--forest-deep)] text-[var(--cream)] px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] focus:outline-none">
              ${options}
            </select>
          </div>
        </nav>
      </header>
    `;
  }

  function hero(strings) {
    return `
      <section id="top" data-hero-section class="relative h-[100svh] min-h-[720px] w-full overflow-hidden bg-[var(--forest-deep)] text-[var(--cream)]">
        <div data-hero-bg class="absolute inset-0">
          <img src="${assetUrl("waste").replace("waste.jpg", "hero.jpg")}" alt="Organic fruit waste transforming into biodegradable packaging" width="1920" height="1080" class="w-full h-full object-cover opacity-90" />
          <div class="absolute inset-0 bg-gradient-to-b from-[var(--forest-deep)]/30 via-transparent to-[var(--forest-deep)]"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-[var(--forest-deep)] via-[var(--forest-deep)]/40 to-transparent"></div>
        </div>

        <div class="absolute top-1/4 right-[10%] w-72 h-72 rounded-full bg-[var(--amber)]/20 blur-3xl animate-float-slow pointer-events-none"></div>

        <div data-hero-content class="relative h-full container mx-auto px-6 flex flex-col justify-end pb-20 md:pb-28 max-w-7xl">
          <div data-motion data-motion-load style="${motionStyle(20, 0.8, 0.2)}" class="inline-flex items-center gap-2 self-start glass rounded-full pl-2 pr-4 py-1.5 text-xs uppercase tracking-[0.18em] mb-8">
            <span class="w-6 h-6 rounded-full bg-[var(--amber)] grid place-items-center">
              ${icon("sparkles", "w-3 h-3 text-[var(--forest-deep)]")}
            </span>
            ${escapeHtml(strings.hero.badge)}
          </div>

          <h1 data-motion data-motion-load style="${motionStyle(40, 1, 0.4)}" class="display text-[clamp(2.75rem,7vw,6.5rem)] max-w-5xl text-balance">
            ${escapeHtml(strings.hero.title)}
          </h1>

          <p data-motion data-motion-load style="${motionStyle(20, 0.8, 0.7)}" class="mt-6 max-w-xl text-base md:text-lg text-[var(--cream)]/75 leading-relaxed">
            ${escapeHtml(strings.hero.subtitle)}
          </p>

          <div data-motion data-motion-load style="${motionStyle(20, 0.8, 0.9)}" class="mt-10 flex flex-wrap gap-3">
            <a href="#revolution" class="group inline-flex items-center gap-2 bg-[var(--amber)] text-[var(--forest-deep)] rounded-full pl-6 pr-5 py-3.5 font-medium hover:scale-[1.03] transition">
              ${escapeHtml(strings.hero.discoverInnovation)}
              <span class="w-7 h-7 rounded-full bg-[var(--forest-deep)] text-[var(--amber)] grid place-items-center group-hover:rotate-45 transition-transform">
                ${icon("arrowRight", "w-3.5 h-3.5")}
              </span>
            </a>
            <a href="#contact" class="inline-flex items-center gap-2 glass rounded-full pl-6 pr-5 py-3.5 font-medium hover:bg-white/15 transition">
              ${escapeHtml(strings.hero.joinMovement)} ${icon("arrowUpRight", "w-4 h-4")}
            </a>
          </div>
        </div>

        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-xs uppercase tracking-[0.3em] text-[var(--cream)]/60">
          <div class="w-px h-10 bg-gradient-to-b from-[var(--amber)] to-transparent"></div>
          ${escapeHtml(strings.hero.scroll)}
        </div>
      </section>
    `;
  }

  function marquee(strings) {
    const items = [...strings.marquee, ...strings.marquee, ...strings.marquee]
      .map(
        (item) =>
          `<span class="flex items-center gap-12">${escapeHtml(item)} <span class="text-[var(--cream)]/30">\u2726</span></span>`,
      )
      .join("");
    return `
      <div class="bg-[var(--forest-deep)] text-[var(--amber)] py-5 border-y border-white/5 overflow-hidden">
        <div class="flex gap-12 animate-marquee whitespace-nowrap font-display text-2xl md:text-3xl italic">
          ${items}
        </div>
      </div>
    `;
  }

  function sustainStats(strings) {
    const stats = strings.sustainStats || translations.en.sustainStats || [];
    const statIcons = ["recycle", "factory", "leaf", "sprout"];
    const cards = stats
      .map(
        (stat, index) => `
          <div data-motion style="${motionStyle(24, 0.65, index * 0.08)}" class="sustain-item">
            <div class="sustain-icon" aria-hidden="true">
              ${icon(statIcons[index] || "leaf", "w-7 h-7")}
            </div>
            <div class="sustain-text">
              <div class="sustain-value">${escapeHtml(stat.value)}</div>
              <div class="sustain-desc">${escapeHtml(stat.label)}</div>
            </div>
          </div>
        `,
      )
      .join("");

    return `
      <section class="sustain-section bg-[var(--cream)]">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="sustain-container" role="list" aria-label="${escapeHtml(strings.sustainStatsLabel || "Sustainability metrics")}">
            ${cards}
          </div>
        </div>
      </section>
    `;
  }

  function crisis(strings) {
    const stats = strings.crisis.stats
      .map((stat, index) => {
        const colorClass =
          index === 0 ? "text-[var(--amber)]" : "text-[var(--cream)]";
        return `
          <div data-motion style="${motionStyle(30, 0.6, index * 0.1)}" class="bg-[var(--forest-deep)] p-8 md:p-10">
            <div class="display text-5xl md:text-7xl ${colorClass}">
              <span data-counter data-counter-to="${stat.value}" data-counter-suffix="${escapeHtml(stat.suffix)}" data-counter-decimals="${stat.decimals || 0}" class="tabular-nums">${escapeHtml(counterInitial(stat))}</span>
            </div>
            <p class="mt-4 text-sm text-[var(--cream)]/60 leading-snug">${escapeHtml(stat.label)}</p>
          </div>
        `;
      })
      .join("");

    return `
      <section id="crisis" class="relative bg-[var(--forest-deep)] text-[var(--cream)] py-28 md:py-40">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="grid md:grid-cols-12 gap-12 items-end mb-20">
            <div class="md:col-span-7">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--amber)] mb-6">
                ${escapeHtml(strings.crisis.label)}
              </p>
              <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance">
                ${escapeHtml(strings.crisis.titlePrefix)} <span class="italic text-[var(--amber)]">${escapeHtml(strings.crisis.titleHighlight)}</span>
              </h2>
            </div>
            <p class="md:col-span-5 text-[var(--cream)]/70 text-lg leading-relaxed">
              ${escapeHtml(strings.crisis.description)}
            </p>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-white/10 rounded-3xl overflow-hidden">
            ${stats}
          </div>
        </div>
      </section>
    `;
  }

  function revolution(strings) {
    const stages = strings.revolution.stages
      .map(
        (stage, index) => `
          <div data-motion style="${motionStyle(40, 0.7, index * 0.12)}" class="relative group">
            <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-[var(--forest-deep)]">
              <img src="${assetUrl(stage.img)}" alt="${escapeHtml(stage.title)}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
              <div class="absolute inset-0 bg-gradient-to-t from-[var(--forest-deep)]/80 via-transparent to-transparent"></div>
              <div class="absolute top-4 left-4 w-8 h-8 rounded-full bg-[var(--amber)] text-[var(--forest-deep)] grid place-items-center text-xs font-medium">
                0${index + 1}
              </div>
              <div class="absolute bottom-0 inset-x-0 p-5 text-[var(--cream)]">
                <h3 class="display text-2xl">${escapeHtml(stage.title)}</h3>
                <p class="text-xs text-[var(--cream)]/75 mt-1.5 leading-snug">
                  ${escapeHtml(stage.desc)}
                </p>
              </div>
            </div>
          </div>
        `,
      )
      .join("");
    return `
      <section id="revolution" class="relative bg-[var(--cream)] py-28 md:py-40 overflow-hidden">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="max-w-3xl mb-20">
            <p class="text-xs uppercase tracking-[0.3em] text-[var(--forest)] mb-6">
              ${escapeHtml(strings.revolution.label)}
            </p>
            <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance text-[var(--forest-deep)]">
              ${escapeHtml(strings.revolution.titlePrefix)} <span class="italic">${escapeHtml(strings.revolution.titleHighlight)}</span>
            </h2>
            <p class="mt-6 text-lg text-[var(--forest)]/70 leading-relaxed">
              ${escapeHtml(strings.revolution.description)}
            </p>
          </div>

          <div class="relative">
            <div class="hidden md:block absolute top-1/2 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[var(--forest)]/20 to-transparent"></div>
            <div class="grid md:grid-cols-5 gap-6">
              ${stages}
            </div>
          </div>
        </div>
      </section>
    `;
  }

  function whyAqcha(strings) {
    const cards = strings.whyAqcha.features
      .map((feature, index) => {
        const active = index === 0;
        return `
          <button data-why-card data-index="${index}" data-motion style="${motionStyle(30, 0.5, index * 0.06)}" class="${whyCardClass(active)}">
            <div data-why-icon class="${whyIconClass(active)}">
              ${icon(whyIcons[index], "w-5 h-5")}
            </div>
            <div class="display text-3xl md:text-4xl mb-3">${escapeHtml(feature.title)}</div>
            <p data-why-copy class="${whyCopyClass(active)}">
              ${escapeHtml(feature.desc)}
            </p>
            ${icon("arrowUpRight", whyArrowClass(active))}
          </button>
        `;
      })
      .join("");
    return `
      <section id="why" class="bg-[var(--bone)] py-28 md:py-40">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="max-w-3xl mb-16">
            <p class="text-xs uppercase tracking-[0.3em] text-[var(--forest)] mb-6">
              ${escapeHtml(strings.whyAqcha.label)}
            </p>
            <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance text-[var(--forest-deep)]">
              ${escapeHtml(strings.whyAqcha.titlePrefix)} <span class="italic">${escapeHtml(strings.whyAqcha.titleHighlight)}</span>
            </h2>
          </div>
          <div class="grid md:grid-cols-3 gap-4">
            ${cards}
          </div>
        </div>
      </section>
    `;
  }

  function whyCardClass(active) {
    return `text-left group relative rounded-3xl p-8 md:p-10 transition-all duration-500 overflow-hidden ${
      active
        ? "bg-[var(--forest-deep)] text-[var(--cream)]"
        : "bg-white text-[var(--forest-deep)] hover:bg-[var(--forest-deep)]/[.03]"
    }`;
  }

  function whyIconClass(active) {
    return `w-12 h-12 rounded-xl grid place-items-center mb-8 transition-colors ${
      active
        ? "bg-[var(--amber)] text-[var(--forest-deep)]"
        : "bg-[var(--forest-deep)]/5 text-[var(--forest-deep)]"
    }`;
  }

  function whyCopyClass(active) {
    return `text-sm leading-relaxed ${
      active ? "text-[var(--cream)]/70" : "text-[var(--forest)]/60"
    }`;
  }

  function whyArrowClass(active) {
    return `absolute top-8 right-8 w-5 h-5 transition-all ${
      active ? "text-[var(--amber)] rotate-0" : "text-[var(--forest)]/30 -rotate-45"
    }`;
  }

  function products(strings) {
    const cards = strings.products.products
      .map(
        (product, index) => `
          
            <a href="${productHref(product.id)}" data-motion style="${motionStyle(50, 0.7, index * 0.1)}" class="product-card group relative rounded-3xl bg-white border border-[var(--forest)]/10 shadow-[0_6px_24px_rgba(0,0,0,0.08)] p-4 flex flex-col hover:shadow-md transition-shadow duration-300 overflow-hidden no-underline">
              <img src="${assetUrl('design.png')}" alt="design" class="absolute -top-5 -left-5 w-20 h-20 object-cover pointer-events-none" />
              <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-[var(--bone)] flex items-center justify-center">
                <img src="${assetUrl(product.img)}" alt="${escapeHtml(product.title)}" loading="lazy" class="max-h-44 w-auto object-contain transition-transform duration-[900ms] group-hover:scale-105" />
              </div>
              <div class="pt-6 pb-6 px-2 flex-1">
                <span class="text-[10px] uppercase tracking-[0.25em] text-[var(--forest)]/50 mb-2 block">${escapeHtml(product.tag)}</span>
                <h3 class="display text-2xl text-[var(--forest-deep)] mb-2">${escapeHtml(product.title)}</h3>
                <p class="mt-0 text-sm text-[var(--forest)]/65 leading-relaxed">${escapeHtml(product.desc)}</p>
              </div>
              <button class="absolute bottom-4 right-4 w-10 h-10 rounded-full bg-[var(--forest-deep)] text-[var(--cream)] flex items-center justify-center shadow-md">
                ${icon("arrowRight", "w-4 h-4")}
              </button>
            </a>
        `,
      )
      .join("");
    return `
      <section id="products" class="bg-[var(--cream)] py-28 md:py-40">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="flex flex-wrap items-end justify-between gap-8 mb-16">
            <div class="max-w-2xl">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--forest)] mb-6">
                ${escapeHtml(strings.products.label)}
              </p>
              <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance text-[var(--forest-deep)]">
                ${escapeHtml(strings.products.titlePrefix)} <span class="italic">${escapeHtml(strings.products.titleHighlight)}</span>
              </h2>
            </div>
            <a href="${homeHash("#contact")}" class="inline-flex items-center gap-2 text-[var(--forest-deep)] font-medium border-b border-[var(--forest-deep)] pb-1 hover:gap-3 transition-all">
              ${escapeHtml(strings.products.requestSample)} ${icon("arrowRight", "w-4 h-4")}
            </a>
          </div>

          <div id="products-grid" class="grid md:grid-cols-3 gap-6">
            ${cards}
          </div>
        </div>
      </section>
    `;
  }

  function impact(strings) {
    const metrics = strings.impact.metrics
      .map(
        (metric, index) => `
          <div>
            <div class="display text-4xl md:text-6xl text-[var(--amber)]">
              <span data-counter data-counter-to="${metric.value}" data-counter-suffix="${escapeHtml(metric.suffix)}" data-counter-decimals="${metric.decimals || 0}" class="tabular-nums">${escapeHtml(counterInitial(metric))}</span>
            </div>
            <p class="mt-3 text-sm text-[var(--cream)]/70">${escapeHtml(metric.label)}</p>
            <div class="mt-4 h-1 rounded-full bg-white/10 overflow-hidden">
              <div data-progress style="--progress-width:${60 + index * 10}%;--progress-delay:${0.3 + index * 0.15}s;" class="h-full bg-gradient-to-r from-[var(--amber)] to-[var(--amber-soft)]"></div>
            </div>
          </div>
        `,
      )
      .join("");
    return `
      <section id="impact" class="relative bg-[var(--forest-deep)] text-[var(--cream)] py-28 md:py-40 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-[var(--amber)]/10 blur-[120px] pointer-events-none"></div>
        <div class="container mx-auto px-6 max-w-7xl relative">
          <div class="grid md:grid-cols-12 gap-12 items-end mb-16">
            <div class="md:col-span-7">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--amber)] mb-6">
                ${escapeHtml(strings.impact.label)}
              </p>
              <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance">
                ${escapeHtml(strings.impact.titlePrefix)} <span class="italic text-[var(--amber)]">${escapeHtml(strings.impact.titleHighlight)}</span> ${escapeHtml(strings.impact.titleSuffix)}
              </h2>
            </div>
            <p class="md:col-span-5 text-[var(--cream)]/70 text-lg leading-relaxed">
              ${escapeHtml(strings.impact.description)}
            </p>
          </div>

          <div class="glass rounded-3xl p-8 md:p-12">
            <div class="flex items-center justify-between mb-10">
              <div class="flex items-center gap-3">
                <span class="relative w-3 h-3">
                  <span class="absolute inset-0 rounded-full bg-[var(--amber)] animate-pulse-ring"></span>
                  <span class="absolute inset-0 rounded-full bg-[var(--amber)]"></span>
                </span>
                <span class="text-xs uppercase tracking-[0.25em] text-[var(--cream)]/70">
                  ${escapeHtml(strings.impact.liveImpact)}
                </span>
              </div>
              <span class="text-xs text-[var(--cream)]/50 hidden md:block">
                ${escapeHtml(strings.impact.since)}
              </span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
              ${metrics}
            </div>
          </div>
        </div>
      </section>
    `;
  }

  function contact(strings) {
    const partners = strings.contact.partners
      .map(
        (partner) => `
          <div class="flex items-center gap-3 text-[var(--cream)]/85">
            <span class="w-6 h-6 rounded-full border border-[var(--cream)]/30 grid place-items-center text-[10px]">
              \u2605
            </span>
            <span class="text-sm">${escapeHtml(partner)}</span>
          </div>
        `,
      )
      .join("");
    return `
      <section id="contact" class="bg-[var(--cream)] py-28 md:py-40">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="grid md:grid-cols-12 gap-16">
            <div class="md:col-span-7">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--forest)] mb-6">
                ${escapeHtml(strings.contact.label)}
              </p>
              <h2 class="display text-[clamp(2.25rem,5vw,4.5rem)] text-balance text-[var(--forest-deep)]">
                ${escapeHtml(strings.contact.titlePrefix)}
                <span class="italic"> ${escapeHtml(strings.contact.titleHighlight)}</span>
              </h2>
              <p class="mt-6 text-lg text-[var(--forest)]/65 max-w-xl leading-relaxed">
                ${escapeHtml(strings.contact.description)}
              </p>

              <form class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl">
                <input placeholder="${escapeHtml(strings.contact.placeholders.name)}" class="bg-white border border-[var(--forest)]/10 rounded-2xl px-5 py-4 text-sm placeholder:text-[var(--forest)]/40 focus:outline-none focus:border-[var(--forest-deep)]" />
                <input type="email" placeholder="${escapeHtml(strings.contact.placeholders.email)}" class="bg-white border border-[var(--forest)]/10 rounded-2xl px-5 py-4 text-sm placeholder:text-[var(--forest)]/40 focus:outline-none focus:border-[var(--forest-deep)]" />
                <textarea placeholder="${escapeHtml(strings.contact.placeholders.message)}" rows="4" class="sm:col-span-2 bg-white border border-[var(--forest)]/10 rounded-2xl px-5 py-4 text-sm placeholder:text-[var(--forest)]/40 focus:outline-none focus:border-[var(--forest-deep)] resize-none"></textarea>
                <button type="submit" class="sm:col-span-2 group inline-flex items-center justify-center gap-2 bg-[var(--forest-deep)] text-[var(--cream)] rounded-2xl px-6 py-4 font-medium hover:bg-[var(--forest)] transition">
                  ${icon("mail", "w-4 h-4")}
                  ${escapeHtml(strings.contact.button)}
                  ${icon("arrowRight", "w-4 h-4 group-hover:translate-x-1 transition-transform")}
                </button>
              </form>
            </div>

            <aside class="md:col-span-5">
              <div class="rounded-3xl bg-[var(--forest-deep)] text-[var(--cream)] p-10">
                <p class="text-xs uppercase tracking-[0.25em] text-[var(--amber)]">
                  ${escapeHtml(strings.contact.trustedBackedBy)}
                </p>
                <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-6">
                  ${partners}
                </div>
                <div class="mt-12 pt-8 border-t border-white/10 text-sm text-[var(--cream)]/70 space-y-1.5">
                  <p>${escapeHtml(strings.contact.companyName)}</p>
                  <p>${escapeHtml(strings.contact.companyLocation)}</p>
                  <a href="mailto:${escapeHtml(strings.contact.email)}" class="text-[var(--amber)] hover:underline">
                    ${escapeHtml(strings.contact.email)}
                  </a>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </section>
    `;
  }

  function footer(strings) {
    const copy = strings.footer.copy.replace("{year}", String(new Date().getFullYear()));
    return `
      <footer class="custom-footer text-[var(--cream)] relative" style="padding: 3.5rem 0 2.5rem;">
        <!-- Gold ornament border at TOP -->
        <div class="custom-gold-border" style="background-image: url('${assetUrl('gold_border.png')}');"></div>
        
        <!-- Subtle corner ornament -->
        <div class="absolute top-10 left-4 w-16 h-16 opacity-15 pointer-events-none custom-left-ornament" style="background-image: url('${assetUrl('design.png')}'); background-size: contain; background-repeat: no-repeat; transform: rotate(90deg);"></div>
        
        <!-- Peacock feather - bottom right -->
        <img src="${assetUrl('peacock_feather.png')}" alt="decor" class="custom-peacock-feather" style="position:absolute; right:-20px; bottom:-10px; width:200px; max-width:30vw; opacity:0.85;" />

        <div style="max-width:1100px; margin:0 auto; padding:0 2rem; position:relative; z-index:20;">
          <div class="footer-columns">
            
            <!-- Brand & Tagline -->
            <div class="footer-col footer-brand-col">
              <div style="color:#53b27e; margin-bottom:0.5rem;">
                ${icon("leaf", "w-9 h-9")}
              </div>
              <div style="font-family:var(--font-display,serif); font-size:1.8rem; letter-spacing:0.18em; color:var(--cream,#f5f0e8); text-transform:uppercase; font-weight:600;">AQCHA</div>
              <p style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.2em; color:rgba(219,234,213,0.7); margin-top:0.25rem;">${escapeHtml(strings.footer.tagline)}</p>
            </div>

            <!-- Navigation Column -->
            <div class="footer-col">
              <h4>${escapeHtml(strings.footer.navigation)}</h4>
              <ul>
                <li><a href="${routeHref("/")}">${escapeHtml(currentLocale === 'ar' ? 'الرئيسية' : (currentLocale === 'fr' ? 'Accueil' : 'Home'))}</a></li>
                <li><a href="${routeHref("/why")}">${escapeHtml(strings.footer.about)}</a></li>
                <li><a href="${routeHref("/products")}">${escapeHtml(strings.nav.links[3]?.label || "Produits")}</a></li>
                <li><a href="${routeHref("/impact")}">${escapeHtml(strings.nav.links[4]?.label || "Impact")}</a></li>
              </ul>
            </div>

            <!-- Resources Column -->
            <div class="footer-col">
              <h4>${escapeHtml(strings.footer.ressources)}</h4>
              <ul>
                <li><a href="#">${escapeHtml(strings.footer.blog)}</a></li>
                <li><a href="#">${escapeHtml(strings.footer.innovation)}</a></li>
                <li><a href="#">${escapeHtml(strings.footer.documents)}</a></li>
                <li><a href="#">${escapeHtml(strings.footer.faq)}</a></li>
              </ul>
            </div>

            <!-- Contact & Social Column -->
            <div class="footer-col">
              <h4>${escapeHtml(strings.footer.contact)}</h4>
              <ul>
                <li><a href="mailto:info@aqcha.com" style="color:rgba(219,234,213,0.85); font-weight:500;">info@aqcha.com</a></li>
                <li><span>+212 6 00 00 00 00</span></li>
                <li><span>${escapeHtml(strings.footer.address)}</span></li>
              </ul>
              <!-- Social Icons -->
              <div style="display:flex; gap:0.6rem; margin-top:1.2rem;">
                <a href="#" class="social-circle" aria-label="LinkedIn">in</a>
                <a href="#" class="social-circle" aria-label="Instagram">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
                <a href="#" class="social-circle" aria-label="Facebook">f</a>
              </div>
            </div>

          </div>
        </div>
      </footer>
    `;
  }

  function renderPage(page, locale) {
    currentPage = page;
    currentLocale = locale;
    const strings = translations[locale] || translations.en;
    const app = document.getElementById("app");
    if (!app || !strings) return;

    document.title = pageTitles[page] || pageTitles.home;
    const description = document.querySelector('meta[name="description"]');
    if (description) description.setAttribute("content", pageDescriptions[page] || pageDescriptions.home);

    const mainClass =
      page === "home"
        ? "bg-[var(--cream)] text-[var(--forest-deep)]"
        : "bg-[var(--cream)] text-[var(--forest-deep)] min-h-screen";

    let content = "";
    if (page === "home") {
      content = nav(strings) + hero(strings) + sustainStats(strings) + marquee(strings) + products(strings) + contact(strings) + footer(strings);
    } else if (page === "crisis") {
      content = nav(strings) + crisis(strings) + footer(strings);
    } else if (page === "revolution") {
      content = nav(strings) + revolution(strings) + footer(strings);
    } else if (page === "why") {
      content = nav(strings) + whyAqcha(strings) + footer(strings);
    } else if (page === "products") {
      content = nav(strings) + products(strings) + footer(strings);
    } else if (page === "product") {
      content = nav(strings) + `<div id="product-placeholder"></div>` + footer(strings);
    } else if (page === "cart") {
      content = nav(strings) + `<div id="cart-placeholder"></div>` + footer(strings);
    } else if (page === "checkout") {
      content = nav(strings) + `<div id="checkout-placeholder"></div>` + footer(strings);
    } else if (page === "impact") {
      content = nav(strings) + impact(strings) + footer(strings);
    } else if (page === "contact") {
      content = nav(strings) + contact(strings) + footer(strings);
    }

    app.innerHTML = `<main class="${mainClass}">${content}</main>`;
    setupInteractions();
    // Load products dynamically from server API and replace static grid when available
    if (page === 'products') reloadProductsGrid(); else loadProductsIntoGrid(currentLocale);
    // Page-specific loaders
    if (page === 'product') loadProductPage(currentLocale);
    if (page === 'cart') loadCartPage(currentLocale);
    if (page === 'checkout') loadCheckoutPage(currentLocale);
  }

  function setupInteractions() {
    const localeSelect = document.querySelector("[data-locale-select]");
    if (localeSelect) {
      localeSelect.value = currentLocale;
      localeSelect.addEventListener("change", (event) => {
        const locale = event.target.value;
        if (!locales.includes(locale)) return;
        applyDocumentLocale(locale);
        renderPage(currentPage, locale);
      });
    }

    document.querySelectorAll("form").forEach((form) => {
      form.addEventListener("submit", (event) => event.preventDefault());
    });

    setupMotion();
    setupCounters();
    setupWhyCards();
    setupHeroParallax();
  }

  function setupMotion() {
    requestAnimationFrame(() => {
      document.querySelectorAll("[data-motion-load]").forEach((element) => {
        element.classList.add("is-visible");
      });
    });

    const revealTargets = Array.from(document.querySelectorAll("[data-motion]:not([data-motion-load])"));
    const progressTargets = Array.from(document.querySelectorAll("[data-progress]"));
    if (!("IntersectionObserver" in window)) {
      revealTargets.concat(progressTargets).forEach((element) => element.classList.add("is-visible"));
      return;
    }

    const revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "0px 0px -10% 0px", threshold: 0.01 },
    );
    revealTargets.forEach((element) => revealObserver.observe(element));

    const progressObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            progressObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.2 },
    );
    progressTargets.forEach((element) => progressObserver.observe(element));
  }

  function setupCounters() {
    const counters = Array.from(document.querySelectorAll("[data-counter]"));
    if (!counters.length) return;

    if (!("IntersectionObserver" in window)) {
      counters.forEach((counter) => animateCounter(counter));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "0px 0px -10% 0px", threshold: 0.1 },
    );
    counters.forEach((counter) => observer.observe(counter));
  }

  function animateCounter(element) {
    if (element.dataset.counterAnimated) return;
    element.dataset.counterAnimated = "true";

    const to = Number(element.dataset.counterTo || "0");
    const suffix = element.dataset.counterSuffix || "";
    const decimals = Number(element.dataset.counterDecimals || "0");
    const duration = 2000;
    const start = performance.now();

    function step(now) {
      const raw = Math.min(1, (now - start) / duration);
      const eased = 1 - Math.pow(1 - raw, 3);
      const value = to * eased;
      element.textContent = `${formatCounter(value, decimals)}${suffix}`;
      if (raw < 1) {
        requestAnimationFrame(step);
      } else {
        element.textContent = `${formatCounter(to, decimals)}${suffix}`;
      }
    }

    requestAnimationFrame(step);
  }

  function setupWhyCards() {
    const cards = Array.from(document.querySelectorAll("[data-why-card]"));
    if (!cards.length) return;

    function setActive(activeIndex) {
      cards.forEach((card, index) => {
        const active = index === activeIndex;
        card.className = whyCardClass(active);
        if (card.hasAttribute("data-motion")) card.classList.add("is-visible");
        const iconBox = card.querySelector("[data-why-icon]");
        const copy = card.querySelector("[data-why-copy]");
        const arrow = card.querySelector("svg.absolute");
        if (iconBox) iconBox.className = whyIconClass(active);
        if (copy) copy.className = whyCopyClass(active);
        if (arrow) arrow.className.baseVal = whyArrowClass(active);
      });
    }

    cards.forEach((card, index) => {
      card.addEventListener("mouseenter", () => setActive(index));
    });
  }

  function setupHeroParallax() {
    const section = document.querySelector("[data-hero-section]");
    const bg = document.querySelector("[data-hero-bg]");
    const content = document.querySelector("[data-hero-content]");
    if (!section || !bg || !content) return;

    function update() {
      const rect = section.getBoundingClientRect();
      const height = section.offsetHeight || 1;
      const progress = Math.max(0, Math.min(1, -rect.top / height));
      const y = progress * 180;
      const scale = 1 + progress * 0.12;
      const opacity = Math.max(0, Math.min(1, 1 - progress / 0.8));
      bg.style.transform = `translateY(${y}px) scale(${scale})`;
      content.style.opacity = String(opacity);
    }

    update();
    window.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update);
  }

  async function fetchProducts(locale) {
    return fetchProductsWithParams(locale, {});
  }

  async function fetchProductsWithParams(locale, params) {
    try {
      const qs = new URLSearchParams(Object.assign({ locale }, params));
      const res = await fetch(`${apiUrl('products.php')}?${qs.toString()}`);
      if (!res.ok) return { products: [], total: 0 };
      const data = await res.json();
      return { products: data.products || [], total: data.total || 0, page: data.page || 1, limit: data.limit || 9 };
    } catch (e) {
      return { products: [], total: 0 };
    }
  }

  function renderProductCard(product, index) {
    const href = productHref(product.id);
    return `
      <a href="${href}" data-motion style="${motionStyle(50, 0.7, index * 0.1)}" class="product-card group relative rounded-3xl bg-white border border-[var(--forest)]/10 shadow-[0_6px_24px_rgba(0,0,0,0.08)] p-4 flex flex-col hover:shadow-md transition-shadow duration-300 overflow-hidden no-underline">
        <img src="${assetUrl('design.png')}" alt="design" class="absolute -top-5 -left-5 w-20 h-20 object-cover pointer-events-none" />
        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-[var(--bone)] flex items-center justify-center">
          <img src="${assetUrl(product.img)}" alt="${escapeHtml(product.title)}" loading="lazy" class="max-h-44 w-auto object-contain transition-transform duration-[900ms] group-hover:scale-105" />
        </div>
        <div class="pt-6 pb-6 px-2 flex-1">
          <span class="text-[10px] uppercase tracking-[0.25em] text-[var(--forest)]/50 mb-2 block">${escapeHtml(product.tag || '')}</span>
          <h3 class="display text-2xl text-[var(--forest-deep)] mb-2">${escapeHtml(product.title || '')}</h3>
          <p class="mt-0 text-sm text-[var(--forest)]/65 leading-relaxed">${escapeHtml(product.desc || '')}</p>
        </div>
        <button class="absolute bottom-4 right-4 w-10 h-10 rounded-full bg-[var(--forest-deep)] text-[var(--cream)] flex items-center justify-center shadow-md">
          ${icon("arrowRight", "w-4 h-4")}
        </button>
      </a>
    `;
  }

  async function renderProductsIntoGrid(products) {
    const grid = document.getElementById('products-grid');
    if (!grid) return;
    // ensure controls container exists
    let controls = document.getElementById('products-controls');
    if (!controls) {
      controls = document.createElement('div');
      controls.id = 'products-controls';
      controls.className = 'flex items-center justify-between mb-6';
      grid.parentNode.insertBefore(controls, grid);
    }
    grid.innerHTML = products.map((p, i) => renderProductCard(p, i)).join('');
    // re-init motion and counters for newly injected nodes
    setupMotion();
    setupCounters();
    setupWhyCards();
    setupProductCardClicks(grid);
    // insert category filter and search (once)
    insertProductsControls();
  }

  async function fetchCategories() {
    try {
      const res = await fetch(apiUrl('categories.php'));
      if (!res.ok) return [];
      const data = await res.json();
      return data.categories || [];
    } catch (e) { return []; }
  }

  let productsQueryState = { q: '', category: '', page: 1, limit: 9 };

  function insertProductsControls() {
    const controls = document.getElementById('products-controls');
    if (!controls) return;
    if (controls.dataset.inited) return;
    controls.dataset.inited = '1';
    // create search input and category select
    const left = document.createElement('div');
    const search = document.createElement('input');
    search.placeholder = 'Search products...';
    search.className = 'rounded-full px-4 py-2 border';
    search.addEventListener('input', debounce((e) => {
      productsQueryState.q = e.target.value.trim();
      productsQueryState.page = 1;
      reloadProductsGrid();
    }, 350));
    left.appendChild(search);

    const right = document.createElement('div');
    const catSelect = document.createElement('select');
    catSelect.className = 'rounded-full px-4 py-2 border';
    const defaultOpt = document.createElement('option'); defaultOpt.value=''; defaultOpt.textContent='All categories'; catSelect.appendChild(defaultOpt);
    fetchCategories().then(cats => {
      cats.forEach(c => {
        const o = document.createElement('option'); o.value = c.id; o.textContent = c.name_en; catSelect.appendChild(o);
      });
    });
    catSelect.addEventListener('change', (e) => { productsQueryState.category = e.target.value; productsQueryState.page = 1; reloadProductsGrid(); });
    right.appendChild(catSelect);

    const pagination = document.createElement('div'); pagination.id = 'products-pagination'; pagination.className='ml-4';

    controls.appendChild(left);
    controls.appendChild(right);
    controls.appendChild(pagination);
  }

  function debounce(fn, wait) {
    let t;
    return function(...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
  }

  function setupProductCardClicks(scope) {
    const cards = scope.querySelectorAll('.product-card');
    console.log('[product-card] setupProductCardClicks running, cards=', cards.length);
    cards.forEach((card) => {
      card.classList.add('cursor-pointer');
      const href = card.getAttribute('href');
      console.log('[product-card] card href=', href);
      if (!href) {
        console.warn('[product-card] missing href on card', card);
        return;
      }
      card.addEventListener('click', (event) => {
        if (event.defaultPrevented) return;
        if (event.button !== 0) return;
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        const targetLink = event.target.closest('a');
        if (!targetLink || targetLink !== card) return;
        event.preventDefault();
        card.classList.add('product-card-clicked');
        document.documentElement.classList.add('page-transition-out');
        setTimeout(() => {
          window.location.href = href;
        }, 170);
      });
    });
  }

  async function reloadProductsGrid() {
    const res = await fetchProductsWithParams(currentLocale, { q: productsQueryState.q, category: productsQueryState.category, page: productsQueryState.page, limit: productsQueryState.limit });
    renderProductsIntoGrid(res.products || []);
    renderProductsPagination(res.total || 0, res.page || 1, res.limit || 9);
  }

  function renderProductsPagination(total, page, limit) {
    const pages = Math.max(1, Math.ceil(total / limit));
    const container = document.getElementById('products-pagination');
    if (!container) return;
    container.innerHTML = '';
    if (pages <= 1) return;
    for (let i=1;i<=pages;i++) {
      const a = document.createElement('button'); a.textContent = i; a.className = (i===page?'bg-[var(--forest-deep)] text-white px-3 py-1 rounded ml-1':'px-3 py-1 rounded ml-1');
      a.addEventListener('click', ()=>{ productsQueryState.page = i; reloadProductsGrid(); });
      container.appendChild(a);
    }
  }

  function loadProductsIntoGrid(locale) {
    fetchProductsWithParams(locale, {}).then((result) => {
      if (result && result.products && result.products.length) renderProductsIntoGrid(result.products);
    });
  }

  function getQueryParam(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
  }

  async function loadProductPage(locale) {
    // If server rendered the page, use the embedded JSON data to hydrate immediately
    if (window.__serverRenderedProduct && window.__productData) {
      renderProductDetail(window.__productData, window.__relatedProductsData || []);
      window.__serverRenderedProduct = false; // Reset for subsequent client-side changes
      return;
    }
    const id = getQueryParam('id');
    if (!id) return;
    try {
      const res = await fetch(`${apiUrl(`product.php?id=${encodeURIComponent(id)}&locale=${encodeURIComponent(locale)}`)}`);
      if (!res.ok) return;
      const data = await res.json();
      if (!data.success) return;
      renderProductDetail(data.product, data.related || []);
    } catch (e) {
      // ignore
    }
  }

  function renderProductDetail(product, related) {
    const container = document.querySelector('#app main');
    if (!container) return;
    const strings = translations[currentLocale] || translations.en;
    const pd = strings.productDetail || {};
    const images = Array.isArray(product.images) && product.images.length ? product.images : (product.img ? [product.img] : []);
    const mainImage = images[0] || '';
    const available = product.available && product.stock > 0;
    const createdAt = product.created_at ? new Date(product.created_at) : null;
    const createdStr = createdAt ? createdAt.toLocaleDateString(currentLocale, { year: 'numeric', month: 'long', day: 'numeric' }) : '';
    
    const html = `
      <section class="bg-[var(--cream)] py-24 md:py-32">
        <div class="container mx-auto px-6 max-w-7xl">
          <!-- Back button / Breadcrumbs -->
          <div class="mb-10 flex flex-wrap items-center justify-between gap-4">
            <a href="products.php" class="group inline-flex items-center gap-2 text-sm font-medium text-[var(--forest-deep)] opacity-70 hover:opacity-100 transition-opacity">
              <span class="inline-block transition-transform group-hover:-translate-x-1">←</span>
              ${escapeHtml(pd.back)}
            </a>
            <nav class="text-xs uppercase tracking-wider opacity-50 flex items-center gap-2">
              <a href="${routeHref('home')}" class="hover:underline">${escapeHtml(strings.nav.links[0]?.label || 'Home')}</a>
              <span>/</span>
              <a href="products.php" class="hover:underline">${escapeHtml(pd.category)}</a>
              <?php if (!empty($product['category_name'])): ?>
                <span>/</span>
                <span class="font-semibold">${escapeHtml(product.category_name)}</span>
              <?php endif; ?>
            </nav>
          </div>

          <div class="grid md:grid-cols-12 gap-12 lg:gap-16 items-start">
            <!-- Left: Gallery -->
            <div class="md:col-span-7">
              <div class="rounded-[2rem] overflow-hidden bg-[var(--bone)] shadow-sm border border-[var(--forest)]/5 relative group aspect-square">
                <img id="main-product-image" src="${escapeHtml(mainImage)}" alt="${escapeHtml(product.title)}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <span class="absolute top-6 left-6 glass rounded-full px-4 py-1.5 text-[10px] uppercase tracking-[0.18em] text-[var(--forest-deep)] font-semibold shadow-sm">
                  ${escapeHtml(product.tag || 'ECO')}
                </span>
              </div>
              
              ${images.length > 1 ? `
                <div class="mt-4 grid grid-cols-5 gap-3">
                  ${images.slice(0, 5).map((im, idx) => `
                    <div class="aspect-square rounded-2xl overflow-hidden bg-[var(--bone)] cursor-pointer border-2 transition-all duration-200 thumb-container ${idx === 0 ? 'border-[var(--forest-deep)]' : 'border-transparent'}" data-src="${escapeHtml(im)}">
                      <img src="${escapeHtml(im)}" class="w-full h-full object-cover thumb-image" />
                    </div>
                  `).join('')}
                </div>
              ` : ''}
            </div>

            <!-- Right: Details -->
            <div class="md:col-span-5 flex flex-col">
              <p class="text-xs uppercase tracking-[0.3em] text-[var(--amber)] mb-3 font-semibold">${escapeHtml(product.tag || '')}</p>
              <h1 class="display text-4xl md:text-5xl text-[var(--forest-deep)] mb-4 leading-tight">${escapeHtml(product.title || '')}</h1>
              
              <div class="flex items-center gap-4 mb-6 flex-wrap">
                <div class="text-3xl font-display font-medium text-[var(--forest-deep)]">
                  $${escapeHtml(product.price || '0.00')}
                </div>
                <div>
                  ${available ? `
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[var(--forest)]/10 text-[var(--forest)] px-3 py-1 text-xs font-semibold">
                      <span class="w-2 h-2 rounded-full bg-[var(--forest)] animate-pulse"></span>
                      ${product.stock} ${escapeHtml(pd.available)}
                    </span>
                  ` : `
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 text-red-500 px-3 py-1 text-xs font-semibold">
                      <span class="w-2 h-2 rounded-full bg-red-500"></span>
                      ${escapeHtml(pd.outOfStock)}
                    </span>
                  `}
                </div>
              </div>

              <p class="text-[var(--forest)]/70 leading-relaxed mb-8 text-base border-t border-[var(--forest)]/10 pt-6">
                ${escapeHtml(product.desc || '').replace(/\n/g, '<br>')}
              </p>

              <!-- Cart Form controls -->
              <div class="flex flex-col gap-6 py-6 border-y border-[var(--forest)]/10 mb-8">
                <div class="flex flex-wrap items-center gap-4">
                  <!-- Custom minus/plus qty picker -->
                  <div class="flex items-center bg-[var(--bone)] rounded-2xl p-1.5 border border-[var(--forest)]/5 shadow-inner">
                    <button id="qty-minus" class="w-10 h-10 rounded-xl hover:bg-white/50 text-[var(--forest-deep)] flex items-center justify-center font-bold transition-all focus:outline-none" ${!available ? 'disabled' : ''}>&minus;</button>
                    <input id="qty-input" type="text" value="1" readonly class="w-10 text-center bg-transparent border-none focus:outline-none font-semibold text-sm text-[var(--forest-deep)]" />
                    <button id="qty-plus" class="w-10 h-10 rounded-xl hover:bg-white/50 text-[var(--forest-deep)] flex items-center justify-center font-bold transition-all focus:outline-none" ${!available ? 'disabled' : ''}>+</button>
                  </div>

                  <!-- 'Add to cart' button removed per request -->
                </div>
              </div>

              ${available ? `
              <!-- Direct order form -->
              <div class="bg-[var(--bone)] border border-[var(--forest)]/10 rounded-3xl p-6 mb-8">
                <h2 class="text-2xl font-semibold text-[var(--forest-deep)] mb-5">Commander ce produit</h2>
                <form id="product-order-form" class="space-y-4">
                  <div>
                    <label for="order-fullname" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Nom complet</label>
                    <input id="order-fullname" name="full_name" type="text" required class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="Nom complet" />
                  </div>
                  <div>
                    <label for="order-address" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Adresse</label>
                    <textarea id="order-address" name="address" required rows="3" class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="Adresse de livraison"></textarea>
                  </div>
                  <div>
                    <label for="order-phone" class="block text-sm font-medium text-[var(--forest-deep)] mb-2">Num&eacute;ro de t&eacute;l&eacute;phone</label>
                    <input id="order-phone" name="phone" type="tel" required class="w-full rounded-2xl border border-[var(--forest)]/10 bg-white/90 px-4 py-3 text-sm text-[var(--forest-deep)] focus:border-[var(--forest-deep)] focus:outline-none" placeholder="+212 6 12 34 56 78" />
                  </div>
                  <div class="space-y-3">
                    <button id="product-order-button" type="button" class="btn-order-green w-full inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-4 font-semibold transition-all hover:scale-[1.01] active:scale-[0.99] shadow-sm">Commander</button>
                    <div id="order-feedback" class="text-sm text-[var(--forest)]/80"></div>
                  </div>
                </form>
              </div>
              ` : `
              <div class="bg-[var(--bone)] border border-red-400/20 rounded-3xl p-6 mb-8">
                <p class="text-sm text-red-700">Ce produit est en rupture de stock, commande impossible.</p>
              </div>
              `}
              <!-- Sustainability fact highlights -->
              <div class="bg-white/40 border border-[var(--forest)]/5 rounded-3xl p-6 backdrop-blur shadow-sm">
                <h4 class="text-xs uppercase tracking-[0.2em] text-[var(--forest-deep)]/60 font-semibold mb-4">${escapeHtml(pd.sustainability)}</h4>
                <ul class="space-y-4">
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      ${icon('sprout', 'w-3.5 h-3.5')}
                    </span>
                    <span>${escapeHtml(pd.sustain1)}</span>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      ${icon('recycle', 'w-3.5 h-3.5')}
                    </span>
                    <span>${escapeHtml(pd.sustain2)}</span>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-[var(--forest-deep)]/80">
                    <span class="w-6 h-6 rounded-lg bg-[var(--forest)]/5 text-[var(--forest)] flex items-center justify-center shrink-0 mt-0.5">
                      ${icon('leaf', 'w-3.5 h-3.5')}
                    </span>
                    <span>${escapeHtml(pd.sustain3)}</span>
                  </li>
                </ul>
              </div>

              <div class="mt-4 text-[10px] text-[var(--forest)]/40 flex items-center justify-between px-2">
                <span>${escapeHtml(pd.category)}: ${escapeHtml(product.category_name || '')}</span>
                <span>${createdStr}</span>
              </div>
            </div>
          </div>

          <!-- Related products -->
          ${related && related.length ? `
            <div class="mt-24 border-t border-[var(--forest)]/10 pt-16">
              <h3 class="display text-3xl text-[var(--forest-deep)] mb-8 font-medium">${escapeHtml(pd.relatedProducts)}</h3>
              <div id="related-grid" class="grid md:grid-cols-3 gap-6">
                ${related.map((r, i) => renderProductCard(r, i)).join('')}
              </div>
            </div>
          ` : ''}
        </div>
      </section>
    `;
    container.innerHTML = nav(translations[currentLocale]||translations.en) + html + footer(translations[currentLocale]||translations.en);
    setupInteractions();

    // Custom Quantity Logic
    const minusBtn = document.getElementById('qty-minus');
    const plusBtn = document.getElementById('qty-plus');
    const qtyInput = document.getElementById('qty-input');
    if (minusBtn && plusBtn && qtyInput) {
      minusBtn.addEventListener('click', () => {
        const val = Math.max(1, parseInt(qtyInput.value || '1', 10) - 1);
        qtyInput.value = String(val);
      });
      plusBtn.addEventListener('click', () => {
        const val = Math.min(product.stock || 99, parseInt(qtyInput.value || '1', 10) + 1);
        qtyInput.value = String(val);
      });
    }

    // Gallery Thumbnails Click Handlers
    const mainImg = document.getElementById('main-product-image');
    const thumbContainers = document.querySelectorAll('.thumb-container');
    thumbContainers.forEach(container => {
      container.addEventListener('click', function() {
        if (!mainImg) return;
        const newSrc = this.dataset.src;
        mainImg.src = newSrc;
        thumbContainers.forEach(c => c.classList.remove('border-[var(--forest-deep)]'));
        thumbContainers.forEach(c => c.classList.add('border-transparent'));
        this.classList.remove('border-transparent');
        this.classList.add('border-[var(--forest-deep)]');
      });
    });

    // Cart actions

    const orderForm = document.getElementById('product-order-form');
    const orderButton = document.getElementById('product-order-button');
    const orderFeedback = document.getElementById('order-feedback');
    if (orderButton && orderForm && orderFeedback) {
      orderButton.addEventListener('click', async () => {
        const fullName = (orderForm.elements['full_name']?.value || '').trim();
        const address = (orderForm.elements['address']?.value || '').trim();
        const phone = (orderForm.elements['phone']?.value || '').trim();
        const qty = parseInt(document.getElementById('qty-input').value || '1', 10);
        if (!fullName || !address || !phone) {
          orderFeedback.textContent = 'Veuillez remplir tous les champs.';
          orderFeedback.className = 'text-sm text-red-600';
          return;
        }

        orderButton.disabled = true;
        orderButton.textContent = 'En cours...';
        orderFeedback.textContent = '';

        try {
          const res = await fetch(apiUrl('order.php'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              product_id: product.id,
              qty,
              full_name: fullName,
              address,
              phone,
            }),
          });
          const data = await res.json();
          if (data && data.success) {
            orderFeedback.textContent = `Commande enregistrée ! Numéro #${data.order_id}`;
            orderFeedback.className = 'text-sm text-green-700';
            orderForm.reset();
          } else {
            orderFeedback.textContent = 'Impossible de passer la commande.';
            orderFeedback.className = 'text-sm text-red-600';
          }
        } catch (error) {
          orderFeedback.textContent = 'Erreur serveur, veuillez réessayer.';
          orderFeedback.className = 'text-sm text-red-600';
        } finally {
          orderButton.disabled = false;
          orderButton.textContent = 'Commander';
        }
      });
    }

    // Hydrate Related Products Clicks
    const relatedGrid = document.getElementById('related-grid');
    if (relatedGrid) {
      setupProductCardClicks(relatedGrid);
    }
  }

  async function cartApi(action, body) {
    const opts = { method: 'POST' };
    if (body) opts.body = new URLSearchParams(body);
    const res = await fetch(apiUrl(`cart.php?action=${action}`), opts);
    return res.json();
  }

  async function cartAdd(id, qty) {
    return cartApi('add', { id, qty });
  }

  async function cartUpdate(id, qty) { return cartApi('update', { id, qty }); }
  async function cartRemove(id) { return cartApi('remove', { id }); }

  async function loadCartPage(locale) {
    try {
      const res = await fetch(apiUrl(`cart.php?action=list`));
      const data = await res.json();
      const cart = data.cart || {};
      const ids = Object.keys(cart).map((k)=>parseInt(k,10)).filter(Boolean);
      if (!ids.length) {
        renderCartEmpty();
        return;
      }
      const productsRes = await fetch(apiUrl(`products.php?locale=${encodeURIComponent(locale)}&limit=100`));
      const productsData = await productsRes.json();
      const products = productsData.products || [];
      const map = {};
      products.forEach(p=>map[p.id]=p);
      renderCartPage(cart, map);
    } catch (e) {
      renderCartEmpty();
    }
  }

  function renderCartEmpty() {
    const appMain = document.querySelector('#app main');
    if (!appMain) return;
    appMain.innerHTML = `<section class="py-28"><div class="container mx-auto px-6 max-w-7xl"><h2>Your cart is empty</h2></div></section>`;
  }

  function renderCartPage(cart, productsMap) {
    const items = Object.entries(cart).map(([pid, qty])=>({ id: pid, qty: qty, product: productsMap[pid] }));
    let total = 0;
    const rows = items.map(it => {
      const p = it.product || {};
      const price = parseFloat(p.price || 0);
      const subtotal = price * it.qty;
      total += subtotal;
      return `<div class="grid grid-cols-12 gap-4 py-4 border-b"><div class="col-span-2"><img src="${escapeHtml(p.img||'')}" width="80"/></div><div class="col-span-6"><div class="font-medium">${escapeHtml(p.title||'')}</div><div class="text-sm text-[var(--forest)]/60">${escapeHtml(p.desc||'')}</div></div><div class="col-span-2">$${price.toFixed(2)}</div><div class="col-span-2">Qty: <input data-cart-qty data-id="${it.id}" type="number" value="${it.qty}" min="1" style="width:60px"/></div></div>`;
    }).join('');
    const html = `<section class="py-28"><div class="container mx-auto px-6 max-w-7xl"><h2>Your cart</h2>${rows}<div class="mt-6 text-right font-semibold">Total: $${total.toFixed(2)}</div><div class="mt-6"><a href="${siteUrl('checkout.php')}" class="inline-block bg-[var(--amber)] px-6 py-3 rounded">Proceed to checkout</a></div></div></section>`;
    const appMain = document.querySelector('#app main');
    if (!appMain) return;
    appMain.innerHTML = nav(translations[currentLocale]||translations.en) + html + footer(translations[currentLocale]||translations.en);
    setupInteractions();
    document.querySelectorAll('[data-cart-qty]').forEach(input => {
      input.addEventListener('change', async (e) => {
        const id = e.target.dataset.id;
        const qty = parseInt(e.target.value || '1', 10);
        await cartUpdate(id, qty);
        loadCartPage(currentLocale);
      });
    });
  }

  async function loadCheckoutPage(locale) {
    // render a simple form that posts to /api/checkout.php via fetch
    const appMain = document.querySelector('#app main');
    if (!appMain) return;
    const html = `<section class="py-28"><div class="container mx-auto px-6 max-w-7xl"><h2>Checkout</h2><form id="checkout-form" class="max-w-lg"><div><label>Name</label><input name="name" required /></div><div><label>Email</label><input name="email" type="email" required /></div><div><button type="submit" class="mt-4 inline-block bg-[var(--amber)] px-6 py-3 rounded">Place order</button></div></form></div></section>`;
    appMain.innerHTML = nav(translations[currentLocale]||translations.en) + html + footer(translations[currentLocale]||translations.en);
    setupInteractions();
    document.getElementById('checkout-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(e.target);
      const payload = { name: fd.get('name'), email: fd.get('email') };
      const res = await fetch(apiUrl('checkout.php'), { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
      const data = await res.json();
      if (data && data.success) {
        window.location.href = siteUrl(`checkout.php?success=1&order_id=${encodeURIComponent(data.order_id)}`);
      } else {
        alert('Could not process order');
      }
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const page = (app && app.dataset.page) || document.body.dataset.page || "home";
    const locale = getPreferredLocale();
    applyDocumentLocale(locale);
    renderPage(page, locale);
  });
})();
