const modules = import.meta.glob("./helpers/*.js", { eager: true });
for (const path in modules) {
    const name = path
        .split("/")
        .pop()
        .replace(/\.\w+$/, "");
    window[name] = modules[path].default;
}
