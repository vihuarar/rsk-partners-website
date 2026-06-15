import { M as S, C as e, _ as t, al as P, am as y, G as b, an as R, ao as E, ap as V, N as w, aq as k, ar as O, as as N, at as H, H as L, T as D, au as I, a6 as d, Z as x, av as C, aw as v, P as Z } from "./indexWPE-DF7KtW-T.js";
const _ = (s) => {
  const { action: r, subsites: l, value: n, type: i } = s, a = `wpmdb-${i}-multisite-selector`, c = S(), u = (o) => {
    if (o.target.value === "0")
      return;
    c({
      type: r,
      payload: o.target.value
    });
    const p = P(o.target.value, l);
    if (!p.subsiteName)
      return !1;
    c(
      y({
        selectedSubsite: p.subsiteName,
        selectedSubsiteID: o.target.value,
        type: i
      })
    );
  };
  return /* @__PURE__ */ e.jsx("div", { children: /* @__PURE__ */ e.jsxs(
    "select",
    {
      onChange: u,
      value: n,
      id: a,
      "aria-label": `${i} multisite`,
      children: [
        /* @__PURE__ */ e.jsxs("option", { value: "0", children: [
          "-- ",
          t("Select a subsite", "wp-migrate-db"),
          " --"
        ] }),
        Object.keys(l).map((o, p) => /* @__PURE__ */ e.jsx("option", { value: o, children: Object.values(l)[p] }, p))
      ]
    }
  ) });
}, F = (s) => {
  const r = b((o) => o.migrations), l = b((o) => o.multisite_tools), { current_migration: n } = r, { intent: i } = n, a = S(), c = (o) => {
    const p = o.target.value;
    a({
      type: R,
      payload: p
    });
  };
  let { newPrefix: u } = s;
  return i === "savefile" && (u = /* @__PURE__ */ e.jsx(e.Fragment, { children: /* @__PURE__ */ e.jsx(
    "input",
    {
      type: "text",
      className: "new-prefix-input",
      value: l.new_prefix,
      onChange: c
    }
  ) })), /* @__PURE__ */ e.jsxs("div", { className: `new-prefix${i === "savefile" ? " has-form" : ""}`, children: [
    /* @__PURE__ */ e.jsx("span", { children: t("Exported table prefix: ") }),
    u
  ] });
}, B = (s) => {
  const l = ((n) => {
    const i = [], a = w(n, {
      name: "MST_NO_SUBSITE"
    }), c = w(n, {
      name: "MST_NO_DESTINATION"
    }), u = w(n, {
      name: "MST_EMPTY_PREFIX"
    }), o = w(n, {
      name: "MST_INVALID_PREFIX"
    });
    return (u || o) && i.push(
      /* @__PURE__ */ e.jsx("p", { children: t(
        "Please enter a valid prefix. Letters, numbers and underscores (_) are allowed.",
        "wp-migrate-db"
      ) })
    ), a && i.push(/* @__PURE__ */ e.jsx("p", { children: t("Please select a subsite.", "wp-migrate-db") })), c && i.push(
      /* @__PURE__ */ e.jsx("p", { children: t("Please select a destination subsite.", "wp-migrate-db") })
    ), i;
  })(s.status);
  return l.length === 0 ? null : /* @__PURE__ */ e.jsx(E, { type: "danger", className: "mst-errors", children: l.map((n, i) => /* @__PURE__ */ e.jsx(V.Fragment, { children: n }, i)) });
}, U = ({ hasTablePrefix: s }) => {
  const r = b((m) => m.migrations), l = b((m) => m.multisite_tools), { current_migration: n } = r, { status: i, twoMultisites: a } = n, { sourceSite: c, destinationSite: u } = k(r), o = a ? "subsite-to-subsite" : "subsite-to-single", p = c.site_details.is_multisite === "false" ? u : c;
  return /* @__PURE__ */ e.jsxs("div", { className: `subsites-row ${o}`, children: [
    /* @__PURE__ */ e.jsxs("div", { className: "subsites-selects", children: [
      /* @__PURE__ */ e.jsx(
        _,
        {
          type: "source",
          subsites: p.site_details.subsites,
          action: O,
          value: l.selected_subsite
        }
      ),
      a && /* @__PURE__ */ e.jsxs(e.Fragment, { children: [
        /* @__PURE__ */ e.jsx("div", { className: "subsite-arrow", children: /* @__PURE__ */ e.jsx(N, {}) }),
        /* @__PURE__ */ e.jsx(
          _,
          {
            type: "destination",
            subsites: u.site_details.subsites,
            action: H,
            value: l.destination_subsite
          }
        )
      ] })
    ] }),
    s && /* @__PURE__ */ e.jsx(F, {}),
    /* @__PURE__ */ e.jsx(B, { status: i })
  ] });
}, j = L(
  t(
    `This option requires manually <a href="%s" target="_blank" rel="noreferrer noopener">updating the destination's wp-config.php</a> to work as a multisite install.`,
    "wp-migrate-db"
  ),
  "https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/#replace-single-site-multisite"
), M = L(
  t(
    `This option requires manually <a href="%s" target="_blank" rel="noreferrer noopener">updating the destination's wp-config.php</a> to work as a single site.`,
    "wp-migrate-db"
  ),
  "https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/#replace-multisite-single-site"
), A = {
  subSub: {
    push: {
      1: {
        description: t("Push network to network"),
        postDescription: t(
          "Replaces the entire multisite network with the other network",
          "wp-migrate-db"
        ),
        value: !1
      },
      2: {
        description: t("Push subsite to subsite"),
        postDescription: t(
          "Replaces the subsite of one multisite network with the subsite of the other network",
          "wp-migrate-db"
        ),
        value: !0
      }
    },
    pull: {
      1: {
        description: t("Pull network to network"),
        postDescription: t(
          "Replaces the entire multisite network with the other network",
          "wp-migrate-db"
        ),
        value: !1
      },
      2: {
        description: t("Pull subsite to subsite", "wp-migrate-db"),
        postDescription: t(
          "Replaces the subsite of one multisite network with the subsite of the other network",
          "wp-migrate-db"
        ),
        value: !0
      }
    }
  },
  subSingle: {
    push: {
      1: {
        description: t("Push subsite to single site", "wp-migrate-db"),
        postDescription: t(
          "Replaces the single site with the selected subsite of the multisite network",
          "wp-migrate-db"
        ),
        value: !0
      },
      2: {
        description: t(
          "Push network and replace single site",
          "wp-migrate-db"
        ),
        postDescription: t(
          "Replaces the single site with the entire multisite network",
          "wp-migrate-db"
        ),
        value: !1,
        warning: j
      }
    },
    pull: {
      1: {
        description: t("Pull subsite to single site", "wp-migrate-db"),
        postDescription: t(
          "Replaces the single site with the selected subsite of the multisite network",
          "wp-migrate-db"
        ),
        value: !0
      },
      2: {
        description: t(
          "Pull network and replace single site",
          "wp-migrate-db"
        ),
        postDescription: t(
          "Replaces the single site with the entire multisite network",
          "wp-migrate-db"
        ),
        value: !1,
        warning: j
      }
    }
  },
  singleSub: {
    push: {
      1: {
        description: t("Push single site to subsite", "wp-migrate-db"),
        postDescription: t(
          "Replaces the selected subsite of the multisite network with the single site",
          "wp-migrate-db"
        ),
        value: !0
      },
      2: {
        description: t(
          "Push single site and replace network",
          "wp-migrate-db"
        ),
        postDescription: t(
          "Replaces the entire multisite network with the single site",
          "wp-migrate-db"
        ),
        value: !1,
        warning: M
      }
    },
    pull: {
      1: {
        description: t("Pull single site to subsite", "wp-migrate-db"),
        postDescription: t(
          "Replaces the selected subsite of the multisite network with the single site",
          "wp-migrate-db"
        ),
        value: !0
      },
      2: {
        description: t(
          "Pull single site and replace network",
          "wp-migrate-db"
        ),
        postDescription: t(
          "Replaces the entire multisite network with the single site",
          "wp-migrate-db"
        ),
        value: !1,
        warning: M
      }
    }
  },
  savefile: {
    savefile: {
      1: {
        description: t("Export network", "wp-migrate-db"),
        postDescription: t(
          "Export the entire multisite network",
          "wp-migrate-db"
        ),
        value: !1
      },
      2: {
        description: t("Export subsite", "wp-migrate-db"),
        postDescription: t(
          "Export a subsite of the multisite network",
          "wp-migrate-db"
        ),
        value: !0
      }
    }
  },
  find_replace: {
    find_replace: {
      1: {
        description: t("Find & Replace across network", "wp-migrate-db"),
        postDescription: t(
          "Run Find & Replace across the entire multisite network",
          "wp-migrate-db"
        ),
        value: !1
      },
      2: {
        description: t("Find & Replace within subsite", "wp-migrate-db"),
        postDescription: t(
          "Run Find & Replace within the subsite of the multisite network",
          "wp-migrate-db"
        ),
        value: !0
      }
    }
  }
}, $ = (s) => {
  const { selected: r, labelledby: l } = s;
  return /* @__PURE__ */ e.jsx("div", { children: /* @__PURE__ */ e.jsx(
    "input",
    {
      readOnly: !0,
      className: "option-radio",
      type: "radio",
      name: "multisite-option",
      checked: r,
      "aria-labelledby": l
    }
  ) });
}, q = (s) => {
  const {
    description: r,
    currentOption: l,
    intent: n,
    optionName: i,
    postDescription: a,
    warning: c,
    className: u
  } = s, o = S(), p = (T) => {
    if (l === T)
      return null;
    o(I());
  }, m = `multisite-${i}`, h = n === "savefile" && i, g = i === l;
  return (
    // eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions
    /* @__PURE__ */ e.jsxs(
      "div",
      {
        onClick: () => {
          p(i);
        },
        className: `option ${u || ""}`,
        children: [
          /* @__PURE__ */ e.jsx($, { labelledby: m, selected: g }),
          /* @__PURE__ */ e.jsxs("div", { children: [
            /* @__PURE__ */ e.jsx("div", { id: m, className: "label", children: r }),
            /* @__PURE__ */ e.jsx("div", { className: "option-description", children: a })
          ] }),
          i && g && /* @__PURE__ */ e.jsx(U, { hasTablePrefix: h }),
          c && g && /* @__PURE__ */ e.jsx("div", { className: "migration-warning", children: /* @__PURE__ */ e.jsx(E, { type: "warning", children: D(c) }) })
        ]
      }
    )
  );
}, X = ({ enabled: s, intent: r, migrationType: l }) => /* @__PURE__ */ e.jsx("fieldset", { className: "boxed-options", children: Object.entries(A[l][r]).map(
  ([n, i]) => /* @__PURE__ */ e.jsx(
    q,
    {
      description: i.description,
      currentOption: s,
      intent: r,
      optionName: i.value,
      postDescription: i.postDescription,
      warning: i.warning,
      className: "multisite-selection"
    },
    `multisite-option-${n}`
  )
) }), W = (s) => /* @__PURE__ */ d.createElement("svg", { width: 25, height: 21, viewBox: "0 0 25 21", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...s }, /* @__PURE__ */ d.createElement("path", { d: "M1.23969 14.3084L5.85791 10.568C5.94467 10.4931 6.07736 10.4931 6.16923 10.568L10.7874 14.3049C11.0988 14.5596 11.5632 14.5141 11.8235 14.2095C11.8235 14.1995 11.8286 14.1945 11.8337 14.1895C12.094 13.8649 12.0429 13.3955 11.7214 13.1308L7.10267 9.38951C6.45962 8.87016 5.53537 8.87016 4.89742 9.38951L0.280221 13.1253C-0.0464073 13.385 -0.0923394 13.8544 0.167943 14.179C0.418017 14.4886 0.918167 14.5531 1.23969 14.3084Z", fill: "#666666", fillOpacity: 0.3 }), /* @__PURE__ */ d.createElement("path", { d: "M11.2636 20.0062V16.5106C11.2533 16.206 11.115 15.9164 10.8854 15.7166L6.64941 12.221C6.28196 11.9164 5.74098 11.9164 5.37352 12.221L1.13756 15.7166C0.902797 15.9164 0.770105 16.201 0.759898 16.5056V20.0012H0.754794C0.744587 20.5456 1.1937 20.99 1.74999 21H4.49571C4.7713 20.995 4.99586 20.7703 4.99076 20.5006V17.7541C4.98565 17.4794 5.21021 17.2547 5.4858 17.2547H6.481C6.75659 17.2547 6.98115 17.4794 6.97604 17.7541V20.5006C6.97094 20.7703 7.1955 20.995 7.47109 21H10.2168C10.7731 20.99 11.2687 20.5506 11.2636 20.0062Z", fill: "#666666", fillOpacity: 0.3 }), /* @__PURE__ */ d.createElement("path", { d: "M14.2397 14.3084L18.8579 10.568C18.9447 10.4931 19.0774 10.4931 19.1692 10.568L23.7874 14.3049C24.0988 14.5596 24.5632 14.5141 24.8235 14.2095C24.8235 14.1995 24.8286 14.1945 24.8337 14.1895C25.094 13.8649 25.0429 13.3955 24.7214 13.1308L20.1027 9.38951C19.4596 8.87016 18.5354 8.87016 17.8974 9.38951L13.2802 13.1253C12.9536 13.385 12.9077 13.8544 13.1679 14.179C13.418 14.4886 13.9182 14.5531 14.2397 14.3084Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M24.2636 20.0062V16.5106C24.2533 16.206 24.115 15.9164 23.8854 15.7166L19.6494 12.221C19.282 11.9164 18.741 11.9164 18.3735 12.221L14.1376 15.7166C13.9028 15.9164 13.7701 16.201 13.7599 16.5056V20.0012C13.7497 20.5456 14.1937 20.99 14.75 21H17.4957C17.7713 20.995 17.9959 20.7703 17.9908 20.5006V17.7541C17.9857 17.4794 18.2102 17.2547 18.4858 17.2547H19.481C19.7566 17.2547 19.9811 17.4794 19.976 17.7541V20.5006C19.9709 20.7703 20.1955 20.995 20.4711 21H23.2168C23.7731 20.99 24.2687 20.5506 24.2636 20.0062Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M7.73969 5.30836L12.3579 1.56804C12.4447 1.49313 12.5774 1.49313 12.6692 1.56804L17.2874 5.30487C17.5988 5.55955 18.0632 5.51411 18.3235 5.20949C18.3235 5.1995 18.3286 5.19451 18.3337 5.18951C18.594 4.86492 18.5429 4.39551 18.2214 4.13084L13.6027 0.389513C12.9596 -0.129838 12.0354 -0.129838 11.3974 0.389513L6.78022 4.12534C6.45359 4.38502 6.40766 4.85443 6.66794 5.17903C6.91802 5.48864 7.41817 5.55306 7.73969 5.30836C7.73969 5.30836 7.73969 5.30836 7.71417 5.28889L7.73969 5.30836Z", fill: "#666666", fillOpacity: 0.3 }), /* @__PURE__ */ d.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M17.3755 6.71659C17.5979 6.91005 17.7347 7.18783 17.7523 7.48188L17.7537 7.48188L17.7531 7.49624L17.7537 7.51059L17.7523 7.51059C17.7347 7.80464 17.5979 8.08243 17.3755 8.27589L13.1395 11.7715C12.7721 12.0761 12.2311 12.0761 11.8636 11.7715L7.62766 8.27589C7.39772 8.08024 7.2657 7.80314 7.25078 7.5056L7.25 7.5056L7.25035 7.49624L7.25 7.48688L7.25078 7.48688C7.2657 7.18934 7.39772 6.91224 7.62766 6.71659L11.8636 3.22096C12.2311 2.91634 12.7721 2.91634 13.1395 3.22096L17.3755 6.71659ZM12 6.99998C11.7239 6.99998 11.5 7.22384 11.5 7.49998V9.49998C11.5 9.77613 11.7239 9.99998 12 9.99998H13C13.2761 9.99998 13.5 9.77613 13.5 9.49998V7.49998C13.5 7.22384 13.2761 6.99998 13 6.99998H12Z", fill: "#666666", fillOpacity: 0.3 })), G = (s) => /* @__PURE__ */ d.createElement("svg", { width: 14, height: 21, viewBox: "0 0 14 21", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...s }, /* @__PURE__ */ d.createElement("path", { d: "M1.44631 9.19309L6.83422 4.82938C6.93544 4.74199 7.09025 4.74199 7.19742 4.82938L12.5853 9.18901C12.9485 9.48614 13.4904 9.43312 13.794 9.07773C13.794 9.06608 13.8 9.06025 13.8059 9.05443C14.1096 8.67573 14.0501 8.12808 13.6749 7.8193L8.28644 3.45443C7.53622 2.84852 6.45792 2.84852 5.71365 3.45443L0.326924 7.8129C-0.0541417 8.11585 -0.107729 8.6635 0.195933 9.04219C0.487686 9.40341 1.07119 9.47856 1.44631 9.19309Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M13.1408 15.8406V11.7624C13.1289 11.407 12.9676 11.0691 12.6996 10.836L7.75769 6.75781C7.32899 6.40242 6.69785 6.40242 6.26915 6.75781L1.3272 10.836C1.05331 11.0691 0.898502 11.4012 0.886594 11.7566V15.8348C0.874686 16.4698 1.3927 16.9883 2.0417 17H5.24504C5.56656 16.9942 5.82854 16.732 5.82259 16.4174V13.2131C5.81663 12.8926 6.07862 12.6305 6.40014 12.6305H7.5612C7.88273 12.6305 8.14471 12.8926 8.13876 13.2131V16.4174C8.1328 16.732 8.39478 16.9942 8.71631 17H11.9196C12.5686 16.9883 13.1468 16.4757 13.1408 15.8406Z", fill: "#666666" })), Y = (s) => /* @__PURE__ */ d.createElement("svg", { width: 25, height: 21, viewBox: "0 0 25 21", fill: "none", xmlns: "http://www.w3.org/2000/svg", ...s }, /* @__PURE__ */ d.createElement("path", { d: "M1.23969 14.3084L5.85791 10.568C5.94467 10.4931 6.07736 10.4931 6.16923 10.568L10.7874 14.3049C11.0988 14.5596 11.5632 14.5141 11.8235 14.2095C11.8235 14.1995 11.8286 14.1945 11.8337 14.1895C12.094 13.8649 12.0429 13.3955 11.7214 13.1308L7.10267 9.38951C6.45962 8.87016 5.53537 8.87016 4.89742 9.38951L0.280221 13.1253C-0.0464073 13.385 -0.0923394 13.8544 0.167943 14.179C0.418017 14.4886 0.918167 14.5531 1.23969 14.3084Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M11.2636 20.0062V16.5106C11.2533 16.206 11.115 15.9164 10.8854 15.7166L6.64942 12.221C6.28196 11.9164 5.74098 11.9164 5.37352 12.221L1.13756 15.7166C0.902799 15.9164 0.770106 16.201 0.759899 16.5056V20.0012H0.754796C0.744589 20.5456 1.1937 20.99 1.74999 21H4.49571C4.7713 20.995 4.99586 20.7703 4.99076 20.5006V17.7541C4.98565 17.4794 5.21021 17.2547 5.4858 17.2547H6.481C6.75659 17.2547 6.98115 17.4794 6.97604 17.7541V20.5006C6.97094 20.7703 7.1955 20.995 7.47109 21H10.2168C10.7731 20.99 11.2687 20.5506 11.2636 20.0062Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M14.2397 14.3084L18.8579 10.568C18.9447 10.4931 19.0774 10.4931 19.1692 10.568L23.7874 14.3049C24.0988 14.5596 24.5632 14.5141 24.8235 14.2095C24.8235 14.1995 24.8286 14.1945 24.8337 14.1895C25.094 13.8649 25.0429 13.3955 24.7214 13.1308L20.1027 9.38951C19.4596 8.87016 18.5354 8.87016 17.8974 9.38951L13.2802 13.1253C12.9536 13.385 12.9077 13.8544 13.1679 14.179C13.418 14.4886 13.9182 14.5531 14.2397 14.3084Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M24.2636 20.0062V16.5106C24.2533 16.206 24.115 15.9164 23.8854 15.7166L19.6494 12.221C19.282 11.9164 18.741 11.9164 18.3735 12.221L14.1376 15.7166C13.9028 15.9164 13.7701 16.201 13.7599 16.5056V20.0012C13.7497 20.5456 14.1937 20.99 14.75 21H17.4957C17.7713 20.995 17.9959 20.7703 17.9908 20.5006V17.7541C17.9857 17.4794 18.2102 17.2547 18.4858 17.2547H19.481C19.7566 17.2547 19.9811 17.4794 19.976 17.7541V20.5006C19.9709 20.7703 20.1955 20.995 20.4711 21H23.2168C23.7731 20.99 24.2687 20.5506 24.2636 20.0062Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { d: "M7.73969 5.30836L12.3579 1.56804C12.4447 1.49313 12.5774 1.49313 12.6692 1.56804L17.2874 5.30487C17.5988 5.55955 18.0632 5.51411 18.3235 5.20949C18.3235 5.1995 18.3286 5.19451 18.3337 5.18951C18.594 4.86492 18.5429 4.39551 18.2214 4.13084L13.6027 0.389513C12.9596 -0.129838 12.0354 -0.129838 11.3974 0.389513L6.78022 4.12534C6.45359 4.38502 6.40766 4.85443 6.66794 5.17903C6.91802 5.48864 7.41817 5.55306 7.73969 5.30836C7.73969 5.30836 7.73969 5.30836 7.71417 5.28889L7.73969 5.30836Z", fill: "#666666" }), /* @__PURE__ */ d.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M17.3755 6.71659C17.5979 6.91005 17.7347 7.18783 17.7523 7.48188L17.7537 7.48188L17.7531 7.49624L17.7537 7.51059L17.7523 7.51059C17.7347 7.80464 17.5979 8.08243 17.3755 8.27589L13.1395 11.7715C12.7721 12.0761 12.2311 12.0761 11.8636 11.7715L7.62766 8.27589C7.39772 8.08024 7.2657 7.80314 7.25078 7.5056L7.25 7.5056L7.25035 7.49624L7.25 7.48688L7.25078 7.48688C7.2657 7.18934 7.39772 6.91224 7.62766 6.71659L11.8636 3.22096C12.2311 2.91634 12.7721 2.91634 13.1395 3.22096L17.3755 6.71659ZM12 6.99998C11.7239 6.99998 11.5 7.22384 11.5 7.49998V9.49998C11.5 9.77613 11.7239 9.99998 12 9.99998H13C13.2761 9.99998 13.5 9.77613 13.5 9.49998V7.49998C13.5 7.22384 13.2761 6.99998 13 6.99998H12Z", fill: "#666666" })), f = (s) => {
  const { isMultisite: r, enabled: l } = s;
  return r === "false" ? /* @__PURE__ */ e.jsx(G, { "aria-label": t("Single site", "wp-migrate-db") }) : l ? /* @__PURE__ */ e.jsx(W, { "aria-label": t("Subsite", "wp-migrate-db") }) : /* @__PURE__ */ e.jsx(Y, { "aria-label": t("Multisite", "wp-migrate-db") });
}, z = () => {
  const { multisite_tools: s, migrations: r, panels: l } = b((h) => h), { panelsOpen: n } = l, { current_migration: i } = r, { sourceSite: a, destinationSite: c } = k(r), { intent: u, twoMultisites: o } = i;
  if (x(n, "multisite_tools"))
    return null;
  if (!x(["push", "pull"], u)) {
    const h = s.enabled ? C(s.selected_subsite, a) : a.url;
    return /* @__PURE__ */ e.jsxs("div", { className: "mst-site-summary", children: [
      /* @__PURE__ */ e.jsx(
        f,
        {
          isMultisite: a.is_multisite,
          enabled: s.enabled
        }
      ),
      /* @__PURE__ */ e.jsx("span", { className: "source-site", children: h })
    ] });
  }
  let p = a.url, m = c.url;
  if (s.enabled) {
    const h = a.site_details.is_multisite === "false" ? s.destination_subsite : s.selected_subsite, g = !o && c.site_details.is_multisite === "true" ? s.selected_subsite : s.destination_subsite;
    p = C(h, a), m = C(g, c);
  }
  return /* @__PURE__ */ e.jsxs("div", { className: "mst-site-summary", children: [
    /* @__PURE__ */ e.jsx(
      f,
      {
        isMultisite: a.site_details.is_multisite,
        enabled: s.enabled
      }
    ),
    /* @__PURE__ */ e.jsx("span", { className: "source-site", children: p }),
    /* @__PURE__ */ e.jsx(N, { "aria-label": "migrating to" }),
    /* @__PURE__ */ e.jsx(
      f,
      {
        isMultisite: c.site_details.is_multisite,
        enabled: s.enabled
      }
    ),
    /* @__PURE__ */ e.jsx("span", { className: "destination-site", children: m })
  ] });
}, J = ({
  localURL: s,
  remoteURL: r,
  localIsMultisite: l,
  localSource: n,
  twoMultisites: i,
  migrationType: a,
  ...c
}) => {
  let u = "";
  switch (a) {
    case "subSub":
      u = t(
        "The source <b>(%s)</b> and destination <b>(%s)</b> are both multisite installs.",
        "wp-migrate-db"
      );
      break;
    case "singleSub":
      u = t(
        "The source <b>(%s)</b> is a single-site install, but the destination <b>(%s)</b> is a multisite install.",
        "wp-migrate-db"
      );
      break;
    case "subSingle":
      u = t(
        "The source <b>(%s)</b> is a multisite install, but the destination <b>(%s)</b> is a single-site install.",
        "wp-migrate-db"
      );
      break;
  }
  const o = n ? s : r, p = n ? r : s, m = L(
    u,
    v(o),
    v(p)
  );
  return /* @__PURE__ */ e.jsx("p", { className: c.className, children: D(m) });
}, K = () => {
  const s = b((p) => p.migrations), r = b((p) => p.multisite_tools), { current_migration: l, local_site: n, remote_site: i } = s, { intent: a, twoMultisites: c, localSource: u } = l, o = () => {
    const p = u ? n : i;
    return x(["push", "pull"], a) ? c ? "subSub" : p.site_details.is_multisite === "true" ? "subSingle" : "singleSub" : a;
  };
  return /* @__PURE__ */ e.jsxs(e.Fragment, { children: [
    ["push", "pull"].includes(a) && /* @__PURE__ */ e.jsx(
      J,
      {
        localURL: n.this_url,
        remoteURL: i.site_details.home_url,
        localIsMultisite: n.is_multisite === "true",
        twoMultisites: c,
        localSource: u,
        migrationType: o(),
        className: "mst-blurb"
      }
    ),
    /* @__PURE__ */ e.jsx(
      X,
      {
        enabled: r.enabled,
        intent: a,
        migrationType: o()
      }
    )
  ] });
}, ee = () => {
  const l = b((a) => a.panels.panelsOpen).includes("multisite_tools");
  let n = !1;
  const i = "mst";
  return l || (n = !0), /* @__PURE__ */ e.jsx(
    Z,
    {
      title: t("Multisite", "wp-migrate-db"),
      className: i,
      forceDivider: n,
      panelName: "multisite_tools",
      disabled: !1,
      panelSummary: /* @__PURE__ */ e.jsx(z, { disabled: !1 }),
      children: /* @__PURE__ */ e.jsx(K, {})
    }
  );
};
export {
  J as MSBlurb,
  K as MSContent,
  ee as default
};
//# sourceMappingURL=MultisiteTools-VdsBipOc.js.map
