[![Telegram](https://img.shields.io/badge/Telegram-PresentKim-blue.svg?logo=telegram)](https://t.me/PresentKim)

[![icon/192x192](meta/icon/192x192.png?raw=true)]()

[![License](https://img.shields.io/github/license/PMMPPlugin/PlayerScale.svg?label=License)](LICENSE)
[![Release](https://img.shields.io/github/release/PMMPPlugin/PlayerScale.svg?label=Release)](https://github.com/PMMPPlugin/PlayerScale/releases/latest)
[![Download](https://img.shields.io/github/downloads/PMMPPlugin/PlayerScale/total.svg?label=Download)](https://github.com/PMMPPlugin/PlayerScale/releases/latest)


A plugin set player's scale for PocketMine-MP

## Command
Main command : `/playerscale <default | set | remove | list | lang | reload | save>`

| subcommand | arguments                         | description                |
| ---------- | --------------------------------- | -------------------------- |
| Default    | \<scale percent\>                 | Set default scale          |
| Set        | \<player name\> \<scale percent\> | Set player's scale         |
| Remove     | \<player name\>                   | Remove player's scale      |
| List       | \[page\]                          | Show scale setting list    |
| Lang       | \<language prefix\>               | Load default lang file     |
| Reload     |                                   | Reload all data            |
| Save       |                                   | Save all data              |




## Permission
| permission              | default | description        |
| ----------------------- | ------- | ------------------ |
| playerscale.cmd         | OP      | main command       |
|                         |         |                    |
| playerscale.cmd.default | OP      | default subcommand |
| playerscale.cmd.set     | OP      | set subcommand     |
| playerscale.cmd.remove  | OP      | remove subcommand  |
| playerscale.cmd.list    | OP      | list subcommand    |
| playerscale.cmd.lang    | OP      | lang subcommand    |
| playerscale.cmd.reload  | OP      | reload subcommand  |
| playerscale.cmd.save    | OP      | save subcommand    |




## ChangeLog
### v1.0.0 [![Source](https://img.shields.io/badge/source-v1.0.0-blue.png?label=source)](https://github.com/PMMPPlugin/PlayerScale/tree/v1.0.0) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/PlayerScale/v1.0.0/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/PlayerScale/releases/v1.0.0)
- First release
  
  
---
### v1.1.0 [![Source](https://img.shields.io/badge/source-v1.1.0-blue.png?label=source)](https://github.com/PMMPPlugin/PlayerScale/tree/v1.1.0) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/PlayerScale/v1.1.0/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/PlayerScale/releases/v1.1.0)
- \[Changed\] Remove return type hint
- \[Fixed\] Not use sqlite
  
  
---
### v1.2.0 [![Source](https://img.shields.io/badge/source-v1.2.0-blue.png?label=source)](https://github.com/PMMPPlugin/PlayerScale/tree/v1.2.0) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/PlayerScale/v1.2.0/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/PlayerScale/releases/v1.2.0)
- \[Fixed\] main command config not work
- \[Changed\] translation method
- \[Changed\] command structure
- \[Changed\] Change permisson name
  
  
---
### v1.2.1 [![Source](https://img.shields.io/badge/source-v1.2.1-blue.png?label=source)](https://github.com/PMMPPlugin/PlayerScale/tree/v1.2.1) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/PlayerScale/v1.2.1/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/PlayerScale/releases/v1.2.1)
- \[Changed\] Add return type hint
- \[Fixed\] Violation of PSR-0
- \[Changed\] Rename main class to PlayerScale
- \[Added\] Add PluginCommand getter and setter
- \[Added\] Add getters and setters to SubCommand
- \[Fixed\] Add api 3.0.0-ALPHA11
- \[Added\] Add website and description
- \[Changed\] Show only subcommands that sender have permission to use
