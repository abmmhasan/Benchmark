#!/usr/bin/env bash
set -euo pipefail
exec "$(dirname -- "$0")/../../_support/lifecycle.sh" clear-cache webrick-generated
