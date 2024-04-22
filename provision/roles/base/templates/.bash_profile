#
# {{ ansible_managed }}
#

export LC_ALL=en_US.UTF-8
export LANG=en_US.UTF-8

if [ -d "${HOME}/.bash.d" ] ; then
  for f in "${HOME}"/.bash.d/*.sh ; do
    source "$f"
  done
  unset f
fi

test -f .bashrc && source .bashrc
