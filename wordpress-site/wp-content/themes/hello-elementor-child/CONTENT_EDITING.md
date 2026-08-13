# Content Editing — Current State & Plan

## Where copy lives today

All home page copy is **hardcoded in PHP** inside `template-parts/home/*.php`. Each section file has a PHP array at the top with titles, subtitles, and body text, and the markup renders those values.

| Section | File | Hardcoded fields |
|---|---|---|
| Hero | `template-parts/home/hero.php` | `$hero_slides[]` — title_html, body_html per slide |
| Who We Are | `template-parts/home/who-we-are.php` | `$who_items[]` — num, title, subtitle, body |
| What We Do | `template-parts/home/what-we-do.php` | pillar list (title + body per pillar) |
| Product | `template-parts/home/product.php` | `$product_gallery[]`, `$product_cols[]` — num, body |
| 5\|5\|5 Initiative | `template-parts/home/initiative-555.php` | `$initiative_stats[]`, intro paragraphs |
| Markets | `template-parts/home/markets.php` | `$markets_cities[]`, `$markets_notes[]` |
| Contact | `template-parts/home/contact.php` | headline, intro, address block, socials |

**Consequence:** any copy change requires a developer to edit PHP and redeploy the theme. The client can't self-serve.

## Goal

Give the client a clean, labeled interface in WordPress admin where they can edit every string on the home page without touching code, while keeping the exact layout and design we've built.

## Recommended approach — ACF Options Page

ACF (Advanced Custom Fields) is already installed on this site. We create one **"Home Page" options screen** with a field group per section. Each hardcoded string becomes a labeled field. Templates read the values via `get_field()` / `the_field()`.

### Why this over alternatives

| Approach | Verdict |
|---|---|
| **ACF Options Page** ✅ | Keeps layout locked in code; client edits copy only; no re-training on new tools; ACF is already installed. |
| Elementor rebuild | Client can rearrange things and break the design; loses code-review workflow; slow to iterate. |
| Gutenberg custom blocks | Powerful but heavy — every section needs a `block.json`, JS, PHP render callback. Overkill for this scope. |
| Post meta on the front page | Works, but ACF gives a nicer UI for the same underlying storage. |

## Field group sketch

One options page: **RSK → Home Page**.

### Group: Hero
- `hero_slides` (repeater)
  - `title_html` (WYSIWYG, allowed tags: `<br>`, `<span>`)
  - `body_html` (WYSIWYG, allowed tags: `<strong>`, `<em>`, `<br>`)

### Group: Who We Are
- `who_items` (repeater, min 4 max 4)
  - `num` (text, e.g. "01")
  - `title` (text)
  - `subtitle` (text)
  - `body` (textarea)

### Group: What We Do
- `pillars` (repeater)
  - `title` (text)
  - `body` (textarea)
  - `image` (image)

### Group: Product
- `product_gallery` (gallery — image ids only)
- `product_cols` (repeater)
  - `num` (text)
  - `body` (textarea)

### Group: 5|5|5 Initiative
- `initiative_intro_1` (textarea)
- `initiative_intro_2` (textarea)
- `initiative_stats` (repeater)
  - `num` (text)
  - `label` (text)

### Group: Markets
- `markets_notes` (repeater)
  - `note` (textarea)
- `markets_cities` (repeater)
  - `name` (text)
  - `image` (image)

### Group: Contact
- `contact_intro` (textarea)
- `contact_secondary_heading` (text — e.g. "Partner With Us")
- `contact_email_general` (email)
- `contact_email_careers` (email)
- `contact_socials` (repeater — label, url)

## Migration steps

For each section:

1. Register the field group in `functions.php` (or in the ACF UI, then export as PHP into the theme).
2. Replace the hardcoded PHP array at the top of the template with `$data = get_field('...', 'option');`.
3. Loop / echo from `$data` instead of the literal array.
4. Sanity-check on staging with the client's real edits.

Do it **one section at a time** so we can review each in isolation.

## Effort estimate

- Options page + hero + who-we-are wired up: half a day.
- Remaining five sections: another half day.
- Client walkthrough / brief admin guide: 1–2 hours.

Total: roughly a full day of dev, plus review time.

## Things to keep in code (do not expose in admin)

- Section order (`front-page.php`)
- All layout / Tailwind classes
- Animation timing (`--rsk-reveal-delay`)
- Video source paths
- Colors, fonts, section transitions

The admin surface should stay small and focused on **copy only**. Anything else changing requires a developer touch, which is the boundary that keeps the design intact.
