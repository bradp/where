# Where

A WordPress plugin to display your site's environment type in the admin bar.

## Available Filters

- `where_env_should_add_env_type` - Defaults to true if the user is an admin and the admin bar is showing. Filter this to allow different roles to view as well.
- `where_env_environment_type` - Modify the environment type. You'll also need to use this filter if you're running an older version of WP that doesn't have the 'get_environment_type' function.
- `where_env_styles` - An array of colors/icons to use for the different environment types.
