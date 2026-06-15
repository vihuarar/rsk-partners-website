import { B as D, C as e, D as A, _ as t, E as $, F, G as P, H as O, J as v, K as G, L as U, M as S, N as q, P as R, O as g, Q as b, T as B, V as C, W as H, s as J, X as V, Y as z, Z as K, $ as Q, a0 as W, a1 as X, a2 as Y } from "./indexWPE-DF7KtW-T.js";
import { E as Z } from "./ExcludeFiles-DVcUvO67.js";
const ee = "_options_8lfqr_7", ie = "_option_8lfqr_7", o = {
  "media-files-body": "_media-files-body_8lfqr_1",
  options: ee,
  option: ie,
  "option-label": "_option-label_8lfqr_25 _text-base_iyx6q_21 _font-medium_iyx6q_5",
  "option-description": "_option-description_8lfqr_30 _text-sm_iyx6q_15 _font-regular_iyx6q_1",
  "option-chip": "_option-chip_8lfqr_35",
  "option-datepicker": "_option-datepicker_8lfqr_39",
  "radio-wrapper": "_radio-wrapper_8lfqr_43",
  "radio-input": "_radio-input_8lfqr_49 _sr-only_1wbb8_96 _sr-only_e5q2n_4"
}, ae = (i) => ({
  media_files: i.media_files
}), te = ({ media_files: i, updateMFDate: a }) => {
  const s = i.date;
  let l;
  return !s || s === "" ? l = /* @__PURE__ */ new Date() : l = new Date(s), /* @__PURE__ */ e.jsx(
    A,
    {
      name: "media-since-date-time",
      type: "datetime-local",
      value: $(l),
      onChange: (n) => {
        a(new Date(n.target.value).toISOString());
      },
      additionalAttributes: {
        "aria-label": t(
          "Upload media that were added or updated after date and time",
          "wp-migrate-db"
        )
      }
    }
  );
}, se = D(ae, { updateMFDate: F })(te), ne = {
  "summary-details": "_summary-details_plc85_1 _text-sm_iyx6q_15 _font-regular_iyx6q_1"
}, le = () => {
  const i = P((r) => r.media_files), { option: a, last_migration: s, date: l } = i, n = t(
    "since the beginning of time will be migrated",
    "wp-migrate-db"
  ), p = {
    new_subsequent: s ? O(
      t("since %s will be migrated", "wp-migrate-db"),
      v(s)
    ) : n,
    new: l ? O(
      t("since %s will be migrated", "wp-migrate-db"),
      v(l)
    ) : n,
    all: n
  };
  return /* @__PURE__ */ e.jsx("div", { className: ne["summary-details"], children: p[a] || n });
}, oe = (i) => {
  const a = i.profiles.profile_loading, s = G("panelsOpen", i), l = U("status", i), { loaded_profile: n } = i.profiles;
  return {
    isLoading: a,
    panel_info: i.panels,
    migration: i.migrations,
    current_migration: i.migrations.current_migration,
    addons: i.addons,
    media_files: i.media_files,
    status: l,
    panelsOpen: s,
    loaded_profile: n
  };
}, re = {
  pull: t("Pull", "wp-migrate-db"),
  push: t("Push", "wp-migrate-db"),
  savefile: t("Export", "wp-migrate-db")
}, de = (i) => {
  const { selected: a, labelledby: s } = i;
  return /* @__PURE__ */ e.jsxs("div", { className: o["radio-wrapper"], children: [
    /* @__PURE__ */ e.jsx(
      "div",
      {
        className: Q.control,
        "aria-hidden": "true",
        "data-state": a ? "checked" : "unchecked"
      }
    ),
    /* @__PURE__ */ e.jsx(
      "input",
      {
        className: o["radio-input"],
        type: "radio",
        name: "media-option",
        checked: a,
        "aria-labelledby": s,
        readOnly: !0
      }
    )
  ] });
}, N = (i) => {
  const {
    description: a,
    currentOption: s,
    intent: l,
    optionName: n,
    postDescription: p,
    className: r,
    label: m
  } = i, w = S(), _ = (f) => {
    if (s === f)
      return null;
    w(i.setMediaOption(f));
  }, d = `media-${n}`;
  return (
    // eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions
    /* @__PURE__ */ e.jsxs(
      "div",
      {
        onClick: () => {
          _(n);
        },
        className: `${o.option} ${r || ""}`,
        children: [
          /* @__PURE__ */ e.jsx(
            de,
            {
              labelledby: d,
              selected: n === s
            }
          ),
          /* @__PURE__ */ e.jsxs("div", { children: [
            /* @__PURE__ */ e.jsx("span", { id: d, className: o["option-label"], children: O(m, re[l]) }),
            /* @__PURE__ */ e.jsx("div", { className: o["option-description"], children: a }),
            p && /* @__PURE__ */ e.jsx("div", { className: o["option-chip"], children: /* @__PURE__ */ e.jsx(z, { label: p, size: "sm" }) }),
            /* @__PURE__ */ e.jsx("div", { className: o["option-datepicker"], children: n === "new" && s === "new" && /* @__PURE__ */ e.jsx(se, {}) })
          ] })
        ]
      }
    )
  );
}, pe = (i) => {
  const { media_files: a, panelsOpen: s, status: l, migration: n } = i, { current_migration: p, local_site: r } = n, { intent: m, twoMultisites: w, localSource: _ } = p, { enabled: d } = a, f = S(), h = typeof a.available < "u" && !a.available, E = q(l, {
    name: "MF_INVALID_DATE"
  }), I = q(l, {
    name: "MF_OPTION_NULL"
  }), T = P((c) => c.multisite_tools), k = () => {
    const c = _ && r.is_multisite === "false" || !_ && r.is_multisite === "true";
    return !w && c ? t(
      "Copies all files to the uploads folder of the subsite",
      "wp-migrate-db"
    ) : t(
      "Copies all files from the uploads folder of the subsite",
      "wp-migrate-db"
    );
  }, u = {
    all: t("All uploads", "wp-migrate-db"),
    new: t("New and modified uploads by date", "wp-migrate-db"),
    new_subsequent: t("New and modified uploads", "wp-migrate-db")
  }, x = {
    all: T.enabled ? k() : t("Copies all files from the uploads folder", "wp-migrate-db"),
    new: t(
      "Copies new and modified files after a specific date",
      "wp-migrate-db"
    ),
    new_subsequent: t(
      "Copies new and modified files since the last migration",
      "wp-migrate-db"
    )
  }, L = (c) => !K(s, "media_files") && a.option && a.enabled ? /* @__PURE__ */ e.jsxs(e.Fragment, { children: [
    u[a.option],
    /* @__PURE__ */ e.jsx(le, {})
  ] }) : null, M = s.includes("media_files");
  let y = !1;
  d && !M && (y = !0);
  const j = [];
  return y && j.push("has-divider"), d && j.push("enabled"), /* @__PURE__ */ e.jsx("div", { className: "media-files", children: /* @__PURE__ */ e.jsx(
    R,
    {
      title: t("Media Uploads", "wp-migrate-db"),
      className: j.join(" "),
      panelName: "media_files",
      disabled: h,
      enabled: d,
      panelSummary: /* @__PURE__ */ e.jsx(L, { disabled: h, labels: u, ...i }),
      forceDivider: y,
      callback: (c) => H(
        c,
        "media_files",
        M,
        d,
        h,
        i.addOpenPanel,
        i.removeOpenPanel,
        () => f(J(V))
      ),
      toggle: C(),
      hasInput: !0,
      children: /* @__PURE__ */ e.jsxs("div", { className: o["media-files-body"], children: [
        /* @__PURE__ */ e.jsxs("div", { className: "media-files-inner-wrap", children: [
          /* @__PURE__ */ e.jsxs("div", { className: o.options, children: [
            /* @__PURE__ */ e.jsx(
              N,
              {
                description: x.new_subsequent,
                label: u.new_subsequent,
                postDescription: a.last_migration && a.last_migration !== "" ? v(a.last_migration) : "",
                currentOption: a.option,
                optionName: "new_subsequent",
                intent: m,
                setMediaOption: g
              }
            ),
            /* @__PURE__ */ e.jsx(
              N,
              {
                description: x.all,
                label: u.all,
                currentOption: a.option,
                optionName: "all",
                intent: m,
                setMediaOption: g
              }
            ),
            /* @__PURE__ */ e.jsx(
              N,
              {
                description: x.new,
                label: u.new,
                currentOption: a.option,
                optionName: "new",
                intent: m,
                setMediaOption: g,
                className: "option-wrap"
              }
            )
          ] }),
          /* @__PURE__ */ e.jsx(
            Z,
            {
              ...i,
              excludes: a.excludes,
              excludesUpdater: i.updateMFExcludes,
              type: "media"
            }
          )
        ] }),
        E && /* @__PURE__ */ e.jsx(b, { type: "error", children: /* @__PURE__ */ e.jsx(b.Content, { children: B(
          t(
            'The date selected <a href="https://www.youtube.com/watch?v=G3AfIvJBcGo" target="_blank" rel="noopener noreferrer">is in the future</a>, please select a valid date.',
            "wp-migrate-db"
          )
        ) }) }),
        I && /* @__PURE__ */ e.jsx(b, { type: "error", children: /* @__PURE__ */ e.jsx(b.Content, { children: t("Please select a media option above.", "wp-migrate-db") }) })
      ] })
    }
  ) });
}, ue = D(oe, {
  toggleMediaFiles: C,
  setMediaOption: g,
  addOpenPanel: Y,
  removeOpenPanel: X,
  updateMFExcludes: W,
  updateMFDate: F
})(pe);
export {
  ue as default
};
//# sourceMappingURL=MediaFiles-BaHdrHcU.js.map
