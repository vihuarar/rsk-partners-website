import { G as K, Z as Q, C as i, _ as l, T as w, a3 as Y, a4 as F, a5 as Z, M as J, H as x, a6 as X, a7 as ee, P as te, a8 as se, a9 as ie, aa as R, ab as ne, ac as le, Q as E, ad as T, W as ae, N as oe, ae as W, af as re, B as ce, j as I, K as de, L as ue, ag as me, ah as pe, a1 as he, a2 as ge, ai as _e, aj as fe } from "./indexWPE-DF7KtW-T.js";
import { E as xe } from "./ExcludeFiles-DVcUvO67.js";
const be = ({
  panelsOpen: e,
  items: n,
  selected: s,
  selectedOption: o,
  title: r,
  type: a,
  summary: d
}) => {
  const { enabled: h } = K(
    (f) => f.theme_plugin_files[a] || {}
  );
  if (Q(e, a) || !h)
    return null;
  if (["selected", "except"].includes(o) && s.length === 0)
    return /* @__PURE__ */ i.jsx("span", { className: "empty-warning", children: l("Empty selection", "wp-migrate-db") });
  const t = {
    muplugin_files: l("Selected mu-plugin files", "wp-migrate-db"),
    other_files: l("Selected other files", "wp-migrate-db"),
    root_files: l("Selected root files", "wp-migrate-db"),
    core_files: l("Export all Core files", "wp-migrate-db")
  }[a] || d;
  return /* @__PURE__ */ i.jsxs(i.Fragment, { children: [
    /* @__PURE__ */ i.jsx("div", { children: w(t) }),
    /* @__PURE__ */ i.jsx(
      Y,
      {
        selectedItems: s,
        totalItems: n,
        stageName: r,
        option: o
      }
    )
  ] });
}, we = "_notice_7dq2p_1", je = "_title_7dq2p_14 _text-base_iyx6q_21 _font-regular_iyx6q_1", ye = "_divider_7dq2p_19", ve = "_list_7dq2p_27", m = {
  notice: we,
  title: je,
  divider: ye,
  list: ve,
  "list-item": "_list-item_7dq2p_36",
  "list-item-text": "_list-item-text_7dq2p_48 _text-base_iyx6q_21 _font-regular_iyx6q_1"
}, Pe = () => /* @__PURE__ */ i.jsxs("div", { className: m.notice, children: [
  /* @__PURE__ */ i.jsx("h3", { className: m.title, children: l("Which root files should be migrated?", "wp-migrate-db") }),
  /* @__PURE__ */ i.jsx("hr", { className: m.divider }),
  /* @__PURE__ */ i.jsxs("ul", { className: m.list, children: [
    /* @__PURE__ */ i.jsxs("li", { className: m["list-item"], children: [
      /* @__PURE__ */ i.jsx(F, { name: "global:checkCircle", size: "sm", type: "success" }),
      /* @__PURE__ */ i.jsx("span", { className: m["list-item-text"], children: w(
        l(
          '<span class="include">Include</span> content files (documents, media) served by this site to prevent 404 errors at the destination.',
          "wp-migrate-db"
        )
      ) })
    ] }),
    /* @__PURE__ */ i.jsxs("li", { className: m["list-item"], children: [
      /* @__PURE__ */ i.jsx(F, { name: "global:xCircle", size: "sm", type: "error" }),
      /* @__PURE__ */ i.jsx("span", { className: m["list-item-text"], children: w(
        l(
          '<span class="exclude">Exclude</span> platform-specific files that may be incompatible with the destination.',
          "wp-migrate-db"
        )
      ) })
    ] }),
    /* @__PURE__ */ i.jsxs("li", { className: m["list-item"], children: [
      /* @__PURE__ */ i.jsx(F, { name: "global:xCircle", size: "sm", type: "error" }),
      /* @__PURE__ */ i.jsx("span", { className: m["list-item-text"], children: w(
        l(
          '<span class="exclude">Exclude</span> plugin-generated files as they often contain hard-coded paths and can be regenerated if needed.',
          "wp-migrate-db"
        )
      ) })
    ] })
  ] })
] }), Se = (e) => ({
  tables: "table",
  migrate: "migrate",
  import: "import",
  backup: "backup",
  media_files: "media",
  theme_files: "theme",
  themes: "theme",
  plugin_files: "plugin",
  plugins: "plugin",
  muplugin_files: "must-use plugin",
  muplugins: "must-use plugin",
  other_files: "other",
  others: "other",
  core_files: "core",
  core: "core",
  root_files: "root",
  root: "root",
  finalize: "finalize"
})[e.toLowerCase()] || e, Ee = {
  "panel-instructions": "_panel-instructions_1arab_1 _text-base_iyx6q_21 _font-regular_iyx6q_1"
}, Ne = (e, n, s) => {
  let o = [];
  if (!Array.isArray(n))
    return o;
  const r = n.map((a) => a.path);
  switch (s[`${e}_option`]) {
    case "selected":
      s[`${e}_selected`].forEach((a) => {
        r.includes(a) && o.push(a);
      });
      break;
    case "except":
      s[`${e}_excluded`].forEach((a) => {
        r.includes(a) && o.push(a);
      });
      break;
    case "active":
      n.forEach((a) => {
        a.active && o.push(a.path);
      });
      break;
    case "new_updated":
      n.forEach((a) => {
        const d = re(
          a.sourceVersion,
          a.destinationVersion
        );
        ["add", "none", "up"].includes(d) && o.push(a.path);
      });
      break;
    case "all":
      o = r;
      break;
  }
  return o;
};
function Oe(e, n, s, o, r) {
  const a = Ne(
    r,
    Object.values(n),
    e
  ), d = {
    themes: "theme_files",
    plugins: "plugin_files",
    muplugins: "muplugin_files",
    others: "other_files",
    core: "core_files",
    root: "root_files"
  }, { enabled: h = !1 } = e[d[r]] || {}, g = s.includes(d[r]), _ = oe(o, {
    name: `SELECTED_${r.toUpperCase()}_EMPTY`
  });
  return { enabled: h, isOpen: g, selected: a, selectionEmpty: _ };
}
const j = (e, n) => {
  const {
    theme_plugin_files: s,
    panelsOpen: o,
    current_migration: r,
    remote_site: a,
    local_site: d
  } = e, { status: h, intent: g } = r, _ = Z(e), p = J(), { title: u, type: t, panel_name: f, items: v } = n, N = () => g === "savefile" ? v : v.filter((c) => c.path.includes("wpe-site-migration") === !1), k = v.map((c) => c.path), U = (c) => {
    s[`${t}_option`] === "except" && e.updateExcluded(c, t), e.updateSelected(c, t);
  };
  let O = !1;
  const q = {
    ...["push", "pull"].includes(g) && {
      new_updated: x(
        l("New and updated %s versions", "wp-migrate-db"),
        Se(t)
      )
    },
    all: x(l("All %s", "wp-migrate-db"), t),
    active: x(l("Active %s", "wp-migrate-db"), t),
    selected: x(l("Selected %s", "wp-migrate-db"), t),
    except: x(
      l("All %s <b>except</b> those selected", "wp-migrate-db"),
      t
    )
  }, z = Object.entries(q).map(([c, S]) => ({
    value: c,
    label: w(S)
  })), { enabled: P, isOpen: M, selected: b, selectionEmpty: L } = Oe(
    s,
    v,
    o,
    h,
    t
  ), A = () => s[`${t}_option`] === "except" ? W(e.updateExcluded, k, b, t) : W(e.updateSelected, k, b, t), C = (c) => {
    const S = c.map((V) => V.path || V);
    s[`${t}_option`] === "except" ? e.updateExcluded(S, t) : e.updateSelected(S, t);
  };
  X.useEffect(() => {
    s[`${t}_option`] === "select" && p(e.updateSelected(b, t)), s[`${t}_option`] === "except" && e.updateExcluded(b, t);
  }, []), P && !M && (O = !0);
  const $ = [], D = s[`${t}_option`] === "selected" || s[`${t}_option`] === "except";
  O && $.push("has-divider"), P && $.push("enabled");
  const B = {
    themes: "theme",
    plugins: "plugin",
    muplugins: "must-use plugin",
    others: "file or directory",
    core: "file or directory",
    root: "file or directory"
  }, G = {
    muplugins: l(
      "Select any must-use plugins to be included in the migration.",
      "wp-migrate-db"
    ),
    others: l(
      "Select any other files and folders found in the <code>wp-content</code> directory to be included in the migration.",
      "wp-migrate-db"
    ),
    core: l(
      "Including WordPress core files ensures that the exported archive contains the exact version of WordPress installed on this site, which is helpful when replicating the site in a new environment. ",
      "wp-migrate-db"
    ),
    root: l(
      "Select any files and folders from your site's root directory to be included in the migration.",
      "wp-migrate-db"
    )
  }, H = ee(
    f,
    r,
    d,
    a
  );
  return /* @__PURE__ */ i.jsxs(
    te,
    {
      title: u,
      className: $.join(" "),
      panelName: f,
      disabled: _,
      writable: H,
      enabled: P,
      forceDivider: O,
      callback: (c) => ae(
        c,
        f,
        M,
        P,
        _,
        e.addOpenPanel,
        e.removeOpenPanel,
        () => p(T(f))
      ),
      toggle: T(f),
      hasInput: !0,
      bodyClass: "tpf-panel-body",
      panelSummary: /* @__PURE__ */ i.jsx(
        be,
        {
          ...e,
          disabled: _,
          items: N(),
          selectedOption: s[`${t}_option`],
          selected: b,
          title: u,
          type: f,
          summary: q[s[`${t}_option`]]
        }
      ),
      children: [
        /* @__PURE__ */ i.jsxs("div", { className: "tpf-panel-row", children: [
          /* @__PURE__ */ i.jsxs("div", { className: "tpf-panel-column", children: [
            ["others", "muplugins", "core", "root"].includes(t) && /* @__PURE__ */ i.jsxs("p", { className: Ee["panel-instructions"], children: [
              w(G[t]),
              t === "core" && /* @__PURE__ */ i.jsx(
                se,
                {
                  link: "https://deliciousbrains.com/wp-migrate-db-pro/doc/full-site-exports/",
                  content: l(
                    "Learn When to Include Core Files",
                    "wp-migrate-db"
                  ),
                  utmContent: "wordpress-core-files-panel",
                  utmCampaign: "wp-migrate-documentation",
                  anchorLink: "wordpress-core-files"
                }
              )
            ] }),
            ["themes", "plugins"].includes(t) && /* @__PURE__ */ i.jsx(
              ie,
              {
                legend: x(l("%s options", "wp-migrate-db"), t),
                hideLegend: !0,
                options: z,
                value: s[`${t}_option`],
                onChange: (c) => p(R(c, t))
              }
            ),
            t !== "core" && /* @__PURE__ */ i.jsx(
              ne,
              {
                id: `${t}-multiselect`,
                options: N(),
                extraLabels: "",
                stateManager: U,
                selected: b,
                visible: !0,
                disabled: !D,
                updateSelected: C,
                selectInverse: A,
                showOptions: !1,
                type: t,
                themePluginOption: s[`${t}_option`]
              }
            )
          ] }),
          !["core", "root"].includes(t) && /* @__PURE__ */ i.jsx(
            xe,
            {
              ...e,
              excludes: s[`${t}_excludes`],
              excludesUpdater: e.updateExcludes,
              type: t
            }
          ),
          t === "root" && /* @__PURE__ */ i.jsx("div", { className: "root-files-notice-wrapper", children: /* @__PURE__ */ i.jsx(Pe, {}) })
        ] }),
        t !== "core" && D && /* @__PURE__ */ i.jsx(
          le,
          {
            items: N(),
            onSelectAll: C,
            onDeselectAll: () => C([]),
            onInvertSelection: () => A()
          }
        ),
        L && s[`${t}_option`] === "selected" && /* @__PURE__ */ i.jsx(E, { type: "error", children: /* @__PURE__ */ i.jsx(E.Content, { children: x(
          l(
            "Please select at least one %s for migration",
            "wp-migrate-db"
          ),
          B[t]
        ) }) }),
        L && s[`${t}_option`] === "except" && /* @__PURE__ */ i.jsx(E, { type: "error", children: /* @__PURE__ */ i.jsx(E.Content, { children: x(
          l(
            "Please select at least one %s to exclude from migration",
            "wp-migrate-db"
          ),
          t === "themes" ? "theme" : "plugin"
        ) }) })
      ]
    }
  );
}, Ce = (e) => {
  const n = I("current_migration", e), s = I("local_site", e), o = I("remote_site", e), r = de("panelsOpen", e), a = ue("stages", e), d = me("status", e);
  return {
    theme_plugin_files: e.theme_plugin_files,
    current_migration: n,
    local_site: s,
    remote_site: o,
    panelsOpen: r,
    stages: a,
    status: d
  };
};
function y(e, n) {
  const s = {};
  return ["themes", "plugins", "muplugins", "others", "core", "root"].forEach(
    (o, r) => {
      const a = n === "pull" ? e.remote_site.site_details[o] : e.local_site.site_details[o], d = n === "pull" || n === "savefile" ? e.local_site.site_details[o] : e.remote_site.site_details[o];
      let h = a;
      const g = [], _ = (p) => {
        if (d) {
          let u = d[p];
          if (u && u[0].hasOwnProperty("version"))
            return u[0].version;
        }
        return null;
      };
      for (const p in h) {
        let u = h[p];
        if (!u)
          continue;
        let t = {
          name: u[0].name,
          path: u[0].path,
          active: u[0].active
        };
        ["plugins", "themes"].includes(o) && n !== "savefile" && (t = {
          ...t,
          sourceVersion: u[0].version,
          destinationVersion: _(p)
        }), g.push(t);
      }
      return s[o] = g;
    }
  ), s;
}
const $e = (e) => {
  const { intent: n } = e.current_migration, { themes: s } = y(e, n);
  return j(e, {
    title: l("Themes", "wp-migrate-db"),
    type: "themes",
    panel_name: "theme_files",
    items: s
  });
}, Fe = (e) => {
  const { intent: n } = e.current_migration, { plugins: s } = y(e, n);
  return j(e, {
    title: l("Plugins", "wp-migrate-db"),
    type: "plugins",
    panel_name: "plugin_files",
    items: s
  });
}, Ie = (e) => {
  const { intent: n } = e.current_migration, { muplugins: s } = y(e, n);
  return s.length === 0 ? null : j(e, {
    title: l("Must-Use Plugins", "wp-migrate-db"),
    type: "muplugins",
    panel_name: "muplugin_files",
    items: s
  });
}, Te = (e) => {
  const { intent: n } = e.current_migration, { others: s } = y(e, n);
  return s.length === 0 ? null : j(e, {
    title: l("Other Files", "wp-migrate-db"),
    type: "others",
    panel_name: "other_files",
    items: s
  });
}, ke = (e) => {
  const { intent: n } = e.current_migration, { core: s } = y(e, n);
  return n !== "savefile" || s.length === 0 ? null : j(e, {
    title: l("WordPress Core Files", "wp-migrate-db"),
    type: "core",
    panel_name: "core_files",
    items: s
  });
}, qe = (e) => {
  const { intent: n } = e.current_migration, { root: s } = y(e, n);
  return s.length === 0 ? null : j(e, {
    title: l("Root Files", "wp-migrate-db"),
    type: "root",
    panel_name: "root_files",
    items: s
  });
}, Me = (e) => /* @__PURE__ */ i.jsxs("div", { className: "theme-plugin-files", children: [
  /* @__PURE__ */ i.jsx($e, { ...e }),
  /* @__PURE__ */ i.jsx(Fe, { ...e }),
  /* @__PURE__ */ i.jsx(Ie, { ...e }),
  /* @__PURE__ */ i.jsx(Te, { ...e }),
  /* @__PURE__ */ i.jsx(ke, { ...e }),
  /* @__PURE__ */ i.jsx(qe, { ...e })
] }), Ve = ce(Ce, {
  toggleThemePluginFiles: T,
  updateTPFOption: R,
  updateSelected: fe,
  updateExcluded: _e,
  addOpenPanel: ge,
  removeOpenPanel: he,
  updateExcludes: pe
})(Me);
export {
  Ve as default
};
//# sourceMappingURL=ThemePluginFiles-M0attCMj.js.map
