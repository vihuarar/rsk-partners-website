# Hello Elementor Child — RSK Partners Home Template

A WordPress child theme of **Hello Elementor** that adds a custom `front-page.php`
template used **only on the home page**. Every other page keeps the existing
Elementor design.

---

## File layout

```
wp-content/themes/hello-elementor-child/
├── style.css           # Declares child theme (Template: hello-elementor)
├── functions.php       # Enqueues parent + child styles, loads home.css on front page
├── front-page.php      # Custom template — loads ONLY on the home page
├── SETUP.md            # This file
└── assets/
    ├── css/home.css    # All styles for the new home design
    └── images/         # Hero, property, kitchen, contact images
```

---

## Setup steps (replicable)

### 1. Activate the child theme

WP Admin → **Appearance → Themes** → activate **"Hello Elementor Child - RSK Partners"**.

> If you don't see it, confirm the folder is named `hello-elementor-child` and
> sits inside `wp-content/themes/`, and that `style.css` contains the header
> block with `Template: hello-elementor`.

---

### 2. Set a static front page

**Why this matters:** `front-page.php` only takes over when WordPress is told to
use a static page as the homepage. By default WordPress shows the latest blog
posts on `/`, in which case the template never loads.

**The dropdown is empty because you have no Page named "Home" yet.** The
dropdown lists *published Pages* only (post type = `page`), not posts, not
Elementor templates. Create one first:

1. WP Admin → **Pages → Add New**.
2. Title it `Home` (the content can stay empty — `front-page.php` ignores it).
3. Click **Publish**.
4. (Optional but recommended) Create a second page called `Blog` and publish it,
   if you ever want a posts page.
5. Now go to **Settings → Reading**.
6. Choose **"A static page"**.
7. **Homepage** dropdown → select `Home`.
8. **Posts page** dropdown → select `Blog` (only if you created one).
9. Click **Save Changes**.

Visit `/` — `front-page.php` is now serving the homepage.

---

### 3. Drop in the images

Place these files at `wp-content/themes/hello-elementor-child/assets/images/`
(exact filenames matter — they're hardcoded in `front-page.php`):

| Filename             | Used in section        |
| -------------------- | ---------------------- |
| `hero-house.jpg`     | Hero background        |
| `who-interior.jpg`   | "Who We Are" interior  |
| `property-1.jpg`     | "What We Do" tile 1    |
| `property-2.jpg`     | "What We Do" tile 2    |
| `property-3.jpg`     | "What We Do" tile 3    |
| `product-kitchen.jpg`| Product section        |
| `contact-house.jpg`  | Contact section        |

Optimized JPG/WebP, ~1600px wide for hero/product, ~800px for tiles.

---

### 4. Replace placeholder copy

Edit `front-page.php` and update the `<p>` blocks, card titles, and CTA URL.

If you want any of these editable from WP Admin (no code), use **ACF** (already
installed) — add a field group bound to the `Home` page, then in
`front-page.php` swap hardcoded text for `the_field('field_name', $page_id)`.

---

### 5. Override Elementor's `template_include` (already done in this theme)

> **Critical:** Elementor Pro and Hello Elementor's "Elementor Header & Footer"
> page template both hijack `template_include` and replace `front-page.php`
> with the Elementor canvas — even when the child theme is active and the file
> exists.

This child theme's `functions.php` already includes a `template_include` filter
at `PHP_INT_MAX` priority that forces `front-page.php` on the front page.
Nothing to do here unless you remove it.

If you ever wonder why the homepage suddenly reverts: confirm the filter is
still in `functions.php`. Also check **Templates → Theme Builder** for any
**Single Page** template targeting `Front Page` and remove that condition.

---

### 6. Verify

1. Start the local stack (from the repo root):
   ```bash
   docker-compose up -d
   ```
2. Visit the homepage in a browser.
3. Hard-reload (Cmd-Shift-R / Ctrl-Shift-R) to bypass cache.
4. Check the page source — you should see `<main id="rsk-home" class="rsk-home">`.

If the old design still shows: re-check **step 5** (Theme Builder override) and
clear any caching plugin (Breeze is installed on this site — purge it from the
top admin bar).

---

## How the template is wired

| File              | Hook                                              | Purpose                                        |
| ----------------- | ------------------------------------------------- | ---------------------------------------------- |
| `style.css`       | `Template: hello-elementor`                       | Declares this as Hello Elementor's child.      |
| `functions.php`   | `wp_enqueue_scripts` (prio 20)                    | Loads parent CSS, child CSS, then home CSS.    |
| `functions.php`   | `is_front_page()` guard                           | `home.css` is loaded ONLY on the front page.   |
| `front-page.php`  | WordPress template hierarchy                      | Overrides the homepage only. Other pages untouched. |

**Template hierarchy on the home page:**
`front-page.php` → `home.php` → `page.php` → `index.php`
(WordPress picks the first one that exists. We use `front-page.php`.)

---

## Tailwind CSS workflow

The child theme ships with **Tailwind CLI v3** for utility-first styling on
new pages and components. It coexists with the existing hand-rolled CSS
(`home.css`) — adopt it gradually.

### Setup (once per dev machine)

```bash
cd wp-content/themes/hello-elementor-child
npm install
```

### Daily dev loop — leave this running

```bash
npm run watch:css
```

Watches every `.php` file in the theme and rebuilds `assets/css/tailwind.css`
in ~300ms whenever you save. The compiled CSS is enqueued from `functions.php`
with `filemtime()` cache-busting, so a normal browser reload (`Cmd+R`) picks
up the change — no need to re-run any build command, no hard-refresh needed.

If the browser still shows stale CSS after a save:
- **Breeze plugin** is caching the HTML response. Top admin bar →
  **Breeze → Purge All Cache**.
- Hard-refresh with `Cmd+Shift+R` to bypass browser cache.

### One-shot production build

```bash
npm run build:css
```

Use before committing — produces a minified `tailwind.css`. Both `tailwind.css`
and `node_modules/` are listed in `.gitignore` settings appropriately:
`node_modules/` is ignored; the compiled CSS is committed so production
doesn't need Node installed.

| Command            | What it does                                                |
| ------------------ | ----------------------------------------------------------- |
| `npm run watch:css`| Watch + rebuild on save (use during dev)                    |
| `npm run build:css`| One-shot minified build → `assets/css/tailwind.css`         |

### How to use Tailwind in templates

All utilities are **`tw-`-prefixed** to prevent collisions with Elementor /
Hello Elementor / other plugins. Examples:

```html
<div class="tw-flex tw-items-center tw-gap-4 tw-p-6 tw-bg-rsk-navy tw-text-white">
	<h2 class="tw-font-serif tw-text-3xl">Hello Tailwind</h2>
</div>
```

### Brand tokens available out of the box

| Utility prefix     | Available values                                                        |
| ------------------ | ----------------------------------------------------------------------- |
| `tw-bg-*`          | `rsk-navy`, `rsk-navy-deep`, `rsk-blue`, `rsk-blue-soft`, `rsk-cream`   |
| `tw-text-*`        | Same as above, plus `rsk-ink`, `rsk-ink-soft`                           |
| `tw-font-*`        | `serif` (Playfair Display), `sans` (DM Sans)                            |
| `tw-max-w-*`       | `rsk` (1180px), `rsk-wide` (1480px)                                     |

Add new tokens in `tailwind.config.js` under `theme.extend`, then rebuild.

### Important defaults you should know

- **Preflight is OFF.** Tailwind's CSS reset is disabled so it doesn't fight
  Elementor's existing margin/heading styles. You'll need to set things like
  `margin: 0` yourself when needed.
- **Prefix is `tw-`.** All utilities require it — `tw-flex`, not `flex`.
- **Content scan** covers `*.php`, `template-parts/`, and `includes/`. If you
  add a new directory of templates, update the `content` array in
  `tailwind.config.js` so its classes get picked up.
- **Don't edit `assets/css/tailwind.css`** — it's the build output. Edit
  `tailwind.src.css` for global custom CSS to ship alongside utilities, or
  `tailwind.config.js` for tokens and config.

### Working example in this repo

The home page's **MARKETS** section in `front-page.php` is built entirely
with Tailwind utilities — open it as a reference for new sections.

---

## Customizing further

- **Add a new section:** add a `<section class="rsk-section rsk-yourname">` to
  `front-page.php`, then matching styles in `assets/css/home.css`.
- **Change colors / fonts:** edit the CSS custom properties at the top of
  `assets/css/home.css` (`--rsk-navy`, `--rsk-blue`, `--rsk-cream`, etc.).
- **Make markets dynamic:** register a `market` Custom Post Type (the
  `custom-post-type-ui` plugin is already installed), then loop over it where
  the static market cards live.
- **Reuse on other pages:** rename the file to `page-{slug}.php` to target a
  specific page slug instead of the home page only.

---

## Troubleshooting

| Symptom                                    | Fix                                                     |
| ------------------------------------------ | ------------------------------------------------------- |
| Homepage dropdown is empty                 | Create + publish a Page first (see step 2).             |
| New design doesn't appear                  | Disable Elementor Theme Builder homepage template (5).  |
| Images broken                              | Filenames must match the table in step 3 exactly.       |
| Styles missing                             | Hard reload + purge Breeze cache.                       |
| Child theme not listed under Appearance    | Folder name must be `hello-elementor-child` in `themes/`. |
