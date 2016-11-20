#!/usr/bin/env python

import os, argparse

################################################################################
############################## ARGS
################################################################################

def options():
    parser = argparse.ArgumentParser()
    parser.add_argument("compose_name", help="compose filename")
    parser.add_argument("command", help="command name")
    parser.add_argument("-p", "--project", type=str, default="santa-letter", help="project name")
    parser.add_argument("-d", "--directory", type=str, default="compose", help="compose directory")
    parser.add_argument("-o", "--option", nargs='+', type=str, default="", help="options")

    return parser.parse_args()


################################################################################
############################## Functions
################################################################################

def command_mapper(cmd_name):
    if cmd_name == "rm":
        return "rm -f"
    elif cmd_name == "up":
        return "up -d --no-recreate"
    return cmd_name

def handler(filepath, project, cmd_name, options):
    command = command_mapper(cmd_name)
    options = " ".join(options)
    cmd = "docker-compose %s %s %s %s" % (filepath, project, command, options)
    print cmd
    os.system(cmd)

MULTIPLE = {
    "srm": ["stop", "rm"],
    "restart": ["stop", "rm", "up"]
}

def main():
    args = options()
    filepath = "-f %s/%s.yml" % (args.directory, args.compose_name)
    project = "-p %s" % args.project

    commands = [args.command]
    if args.command in MULTIPLE :
        commands = MULTIPLE[args.command]

    for cmd in commands :
        handler(filepath, project, cmd, args.option)

main()
