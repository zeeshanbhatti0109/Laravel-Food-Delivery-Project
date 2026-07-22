export const Can = {
    install(app) {
        app.mixin({
            methods: {
                can(permission) {
                    return this.$page?.props?.auth?.permissions?.includes(permission) ?? false
                },
            },
        })
    },
}
